<?php

namespace Users;

use Zend\Mvc\Controller;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function onDispatch(MvcEvent $e) {
        $e->getTarget()->layout(strtolower(__NAMESPACE__) . '/layout/layout');
    }

    public function getConfig()
    {
        $result = array();

        $configs = glob(__DIR__ . "/config/*.config.php");

        foreach ($configs as $config) {
            if (file_exists($config)) {
                $result = array_merge($result, include($config));
            }
        }

        return $result;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
