<?php

namespace app\modules\adminx\components;

use app\components\AccessHelper;
use app\modules\adminx\models\UserM as User;
use yii\db\Query;
use yii\rbac\Assignment;
use yii\rbac\Item;


class DbManager extends \yii\rbac\DbManager
{
    private $_checkAccessAssignments = [];
    private $_userPermissions = [];
    private $_userRoles = [];
    /**
     * @var string
     */
    public $permCacheKey = 'perm';
    public $permCacheKeyDuration = 180;

    public $childrenRoles = [];
    public $childrenPermissions = [];


    public function init()
    {
        $this->permCacheKey = \Yii::$app->configs->permCacheKey;
        $this->permCacheKeyDuration = \Yii::$app->configs->permCacheKeyDuration;
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * Инициализация $_userPermissions и $_userRoles из кеша
     * @return bool
     */
    public function getUserPermissionsFromCache($userId)
    {
        $data = $this->cache->get($this->permCacheKey);
        if (is_array($data) && isset($data[$userId])) {
            $this->_userPermissions = (!empty($data[$userId]['userPermissions'])) ? $data[$userId]['userPermissions'] : [];
            $this->_userRoles = (!empty($data[$userId]['userRoles'])) ? $data[$userId]['userRoles'] : [];
            return true;
        }

        $this->_userPermissions  = [];
        $this->_userRoles  = [];

        $permItems=$this->getPermissionsByUser($userId);
        //$pe=$this->checkAccessRecursive();
        foreach ($permItems as $item){
            $this->_userPermissions[$item->name] = (!empty($item->ruleName)) ? $item->ruleName : '';
        }
        $permItems = $this->getRolesByUser($userId);
        foreach ($permItems as $item){
            $permissions[$item->name] = (!empty($item->ruleName)) ? $item->ruleName : '';
            $this->_userRoles[$item->name] = (!empty($item->ruleName)) ? $item->ruleName : '';
        }
        if (!is_array($data)){
            $data = [];
        }
        $data [$userId] = [
            'userPermissions' => $this->_userPermissions,
            'userRoles' => $this->_userRoles,
        ];

        $ret = $this->cache->set($this->permCacheKey, $data, $this->permCacheKeyDuration);


        return $ret;
    }


    /**
     * {@inheritdoc}
     */
    public function checkAccess($userId, $permissionName, $params = [])
    {
        $t=1;
        $this->getUserPermissionsFromCache($userId);
        if (empty($this->_userPermissions)) {
            return false;
        }

        $userPermissions = array_merge($this->_userPermissions, $this->_userRoles) ;
        if (isset($userPermissions[$permissionName])){
            if (!empty($userPermissions[$permissionName])){
                //-- если у роли или разрешения есть правило - проверяем его
                $this->loadFromCache(); //-- с использованием кеш rbac
                if (!isset($this->items[$permissionName])) {
                    return false;
                }
                $item = $this->items[$permissionName];

               // $item = $this->getPermission($permissionName); //-- кеш rbac можно не использовать
                return $this->executeRule($userId, $item, $params);
            }
            return true;
        } else {
            return false;
          // return parent::checkAccess($userId, $permissionName, $params); // TODO: Change the autogenerated stub
        }
    }

    /**
     * Сброс кеша разрешений пользователей,
     * если $userId не 0 - сбрасываются данные только одного пользователя
     * @param int $userId
     * @return bool
     */
    public function invalidatePermCache($userId=0)
    {
        $ret = true;
        if ($this->cache !== null) {
            if ($userId > 0){
                $data = $this->cache->get($this->permCacheKey);
                if (is_array($data) && isset($data[$userId])) {
                    unset($data[$userId]);
                }
                if (!empty($data)){
                    $ret = $this->cache->set($this->permCacheKey, $data, $this->permCacheKeyDuration);
                } else {
                    $ret = $this->cache->delete($this->permCacheKey);
                }
            } elseif ($this->cache->exists($this->permCacheKey)) {
                $ret = $this->cache->delete($this->permCacheKey);
            }
        }
        $this->_userPermissions  = [];
        $this->_userRoles  = [];
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function assign($role, $userId)
    {
        $ret = $this->invalidatePermCache($userId); //--xle
        $assignment = new Assignment([
            'userId' => $userId,
            'roleName' => $role->name,
            'createdAt' => time(),
        ]);

        $this->db->createCommand()
            ->insert($this->assignmentTable, [
                'user_id' => $assignment->userId,
                'item_name' => $assignment->roleName,
                'created_at' => $assignment->createdAt,
            ])->execute();

        unset($this->_checkAccessAssignments[(string) $userId]);
        return $assignment;
    }

    /**
     * {@inheritdoc}
     */
    public function revoke($role, $userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return false;
        }
        $ret = $this->invalidatePermCache($userId); //--xle
        unset($this->_checkAccessAssignments[(string) $userId]);
        return $this->db->createCommand()
                ->delete($this->assignmentTable, ['user_id' => (string) $userId, 'item_name' => $role->name])
                ->execute() > 0;
    }

    /**
     * Check whether $userId is empty.
     * @param mixed $userId
     * @return bool
     */
    private function isEmptyUserId($userId)
    {
        return !isset($userId) || $userId === '';
    }

    public function invalidateCache()
    {
        if ($this->cache !== null) {
            $this->cache->delete($this->cacheKey);
            $this->items = null;
            $this->rules = null;
            $this->parents = null;
            $ret = $this->invalidatePermCache(0); //--xle
        }
        $this->_checkAccessAssignments = [];
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllAssignments()
    {
        $this->_checkAccessAssignments = [];
        $this->db->createCommand()->delete($this->assignmentTable)->execute();
        $ret = $this->invalidatePermCache(0); //--xle

    }

    /**
     * {@inheritdoc}
     */
    public function revokeAll($userId)
    {
        if ($this->isEmptyUserId($userId)) {
            return false;
        }
        $ret = $this->invalidatePermCache(0); //--xle
        unset($this->_checkAccessAssignments[(string) $userId]);
        return $this->db->createCommand()
                ->delete($this->assignmentTable, ['user_id' => (string) $userId])
                ->execute() > 0;
    }

    public function getRolePermissionsRecursive($roleName)
    {

    }


    public function getChildrenRoles($roleName)
    {
        $query = new Query();
        $parents = $query->select(['parent'])
            ->from($this->itemChildTable)
            ->where(['child' => $roleName])
            ->column($this->db);
        foreach ($parents as $parent) {
            $this->childrenRoles[] = $parent;
            $this->getChildrenRoles($parent);
        }

    }





}
