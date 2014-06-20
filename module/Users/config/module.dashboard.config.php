<?php

return array(
    'dashboard' => array(
        'users' => array(
            'name' => 'Users',
            'icon' => 'users',
            'order' => 2,
            'route' => 'users',
            'submenu' => array(
                array(
                    'name' => 'New User',
                    'route' => 'users'
                ),
                array(
                    'name' => 'Admins',
                    'route' => 'users'
                ),
            ),
        ),
    ),
);