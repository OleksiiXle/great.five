<?php
return [
    'permissions' => [
        'menuAll' => 'Общее меню для зарегистрированных и не зарегистрированных пользователей',
        'login' => 'Вход в систему',
        'logout' => 'Выход из системы',
        //------------------------------------------------------------------------ МЕНЮ
        'menuAdminSystem' => 'Меню системного администрирования',
        'menuAdminUser' => 'Меню администрирования пользователей',
        'menuTournament' => 'Меню турниров',
        'menuTeam' => 'Меню Команд',

        //------------------------------------------------------------------------ РАЗРЕШЕНИЯ СИСТЕМНОГО АДМИНИСТРИРОВАНИЯ
        'adminSystemCRUD' => 'Редактирование разрешений, ролей, назначение разрешений ролям, системные настройки, редактор меню',
        'adminSystemView' => 'Просмотр админданных',

        //------------------------------------------------------------------------ РАЗРЕШЕНИЯ АДМИНИСТРИРОВАНИЯ ПОЛЬЗОВАТЕЛЕЙ
        'adminUserWelcomeTournamentAdmin' => 'Приглашение администратора турниров',
        'adminUserWelcomeTeamAdmin' => 'Приглашение администратора команды',
        'adminUserWelcomeTeamMember' => 'Приглашение игрока команды',
        'adminUserActivate' => 'Активация/деактивация пользователя',
        'adminUserDelete' => 'Удаление пользователя',

        'viewUserInfo' => 'Просмотр всех данных пользователя',

        //---------------------------------------------------------------------------- ТУРНИРЫ
        'tournamentCRUD' => 'Редактирование ТУРНИРОВ',

        //---------------------------------------------------------------------------- МАТЧИ
        'matchCRUD' => 'Редактирование Матчей',

        //----------------------------------------------------------------------------- КОМАНДЫ
        'teamCreate' => 'Редактирование Команд',
        'teamDelete' => 'Редактирование Команд',
        'teamUpdate' => 'Редактирование Команд',

        //----------------------------------------------------------------------------- ПОСТЫ
        'postCRUD' => 'Редактирование Постов',

        //----------------------------------------------------------------------------- КОММЕНТАРИИ
        'commentCRUD' => 'Редактирование Комментариев',

        //----------------------------------------------------------------------------- СООБЩЕНИЯ
        'messageCRUD' => 'Редактирование Сообщений',
        'testPermission1' => '',
        'testPermission2' => '',
        'testPermission3' => '',

    ],
    'roles' => [
        'adminBoss'  => 'Администратор Главный',
        'adminStaff'  => 'Администратор Пользователей',
        'adminTournament'  => 'Администратор ТУРНИРОВ',
        'adminTeam'  => 'Администратор Команд',
        'userTeamMember'   => 'Пользователь - член команды',
        'userSimple'   => 'Пользователь простой',
        'testRole1'   => '',
        'testRole2'   => '',
        'testRole3'   => '',
    ],
    'rolesPermissions' => [
        'testRole1' => [
            'testPermission1',
        ],
        'testRole2' => [
            'testPermission2',
        ],
        'testRole3' => [
            'testPermission3',
        ],
        'userSimple' => [
            'commentCRUD',
        ],
        'userTeamMember' => [
            'messageCRUD',
        ],
        'adminTeam' => [
            'matchCRUD',
            'teamUpdate',
            'postCRUD',
        ],
        'adminTournament' => [
            'teamCreate',
            'teamDelete',
            'tournamentCRUD',
            'adminUserWelcomeTeamAdmin',
        ],
        'adminStaff' => [
            'menuAdminUser',
            'adminUserWelcomeTournamentAdmin',// 'Приглашение администратора турниров',
            'adminUserWelcomeTeamMember', // 'Приглашение игрока команды',
            'adminUserActivate', //'Активация/деактивация пользователя',
            'adminUserDelete',// 'Удаление пользователя',
        ],
        'adminBoss' => [
            'menuAdminSystem',
            'adminSystemCRUD',
            'adminSystemView',
        ],

    ],
    'rolesChildren' => [
        'testRole2' => [
            'testRole3',
        ],
        'testRole1' => [
            'testRole2',
        ],
        'userTeamMember' => [
            'userSimple',
        ],
        'adminTeam' => [
            'userTeamMember',
        ],
        'adminTournament' => [
            'adminTeam',
        ],
        'adminStaff' => [
            'adminTournament',
        ],
        'adminBoss' => [
            'adminStaff',
        ],
    ]
];
