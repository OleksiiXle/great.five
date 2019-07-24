<?php

use yii\db\Migration;

/**
 * Class m190722_075713_add_col_user
 */
class m190722_075713_add_col_user extends Migration
{
    const TABLE_USER = '{{%user}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->addColumn(self::TABLE_USER, 'refresh_permissions', $this->boolean()->defaultValue(false));
    }


    public function safeDown()
    {
        $this->dropColumn(self::TABLE_USER, '');

        return false;
    }

}