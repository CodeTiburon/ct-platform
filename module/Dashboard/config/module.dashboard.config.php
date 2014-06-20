<?php

return array(
    'dashboard' => array(
        'dashboard' => array(
            'name' => 'Dashboard',
            'icon' => 'tachometer',
            'order' => 1,
            'route' => 'dashboard',
            'submenu' => array(
                array(
                    'name' => 'Cache',
                    'route' => 'dashboard'
                ),
            ),
        ),
    ),
);