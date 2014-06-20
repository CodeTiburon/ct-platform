<?php

return array(
    'router' => array(
        'routes' => array(
            'dashboard' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/dashboard',
                    'defaults' => array(
                        'controller' => 'Dashboard\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
);
