<?php
$t = [
    [
        'name' => 'Системные настройки',
        'route' => '',
        'role' => 'menuAdminSystem',
        'children' => [
            [
                'name'       => 'Разрешения',
                'route'      => '/adminx/auth-item',
                'role' => 'menuAdminSystem',
                'children' => []
            ],
            [
                'name'       => 'Правила',
                'route'      => '/adminx/rule',
                'role' => 'menuAdminSystem',
                'children' => []
            ],
            [
                'name'       => 'Редактор меню',
                'route'      => '/adminx/menux/menu',
                'role' => 'menuAdminSystem',
                'children' => []
            ],
            [
                'name'       => 'Настройки системы',
                'route'      => '/adminx/configs/update',
                'role' => 'menuAdminSystem',
                'children' => []
            ],
            [
                'name'       => 'PHP-info',
                'route'      => 'adminx/user/php-info',
                'role' => 'menuAdminSystem',
                'children' => [],
            ],
            [
                'name'       => 'Переводы',
                'route'      => 'adminx/translation',
                'role' => 'menuAdminSystem',
                'children' => [],
            ],
        ]
    ],
    [
        'name' => 'Администрирование пользователей',
        'route' => '',
        'role' => 'menuAdminUser',
        'children' => [
            [
                'name'       => 'Пользователи',
                'route'      => '/adminx/user',
                'role' => 'menuAdminUser',
                'children' => []
            ],
            [
                'name'       => 'Активность пользователей',
                'route'      => '/adminx/check/user-control',
                'role' => 'menuAdminUser',
                'children' => []
            ],
            [
                'name'       => 'Активность гостей',
                'route'      => '/adminx/check/guest-control',
                'role' => 'menuAdminUser',
                'children' => []
            ],
        ]
    ],
    [
        'name' => 'Кабинет',
        'route' => '',
        'role' => 'menuAll',
        'children' => [
            [
                'name'       => 'Профиль',
                'route'      => '/adminx/user/update-profile',
                'role' => 'menuAll',
                'children' => [],
            ],
            [
                'name'       => 'Смена пароля',
                'route'      => '/adminx/user/change-password',
                'role' => 'menuAll',
                'children' => [],
            ],

        ]
    ],
    [
        'name' => 'Посты',
        'route' => '',
        'role' => 'menuAll',
        'children' => [
            [
                'name'       => 'Список постов',
                'route'      => '/post',
                'role' => 'menuAll',
                'children' => [],
            ],
        ]
    ],
    [
        'name'       => 'Восстановление пароля',
        'route'      => '/adminx/user/request-password-reset',
        'role' => '',
        'children' => [],
    ],
    [
        'name'       => 'Вход',
        'route'      => '/adminx/user/login',
        'role' => '',
        'children' => [],
    ],
    [
        'name'       => 'Регистрация',
        'route'      => '/adminx/user/signup',
        'role' => '',
        'children' => [],
    ]
];

return $t;