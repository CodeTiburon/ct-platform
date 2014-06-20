<?php

namespace Dashboard;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface as Event;
use Zend\ModuleManager\ModuleManager;

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
        $modules = $e->getApplication()->getServiceManager()->get('ModuleManager')->getLoadedModules();
        $e->getTarget()->layout()->navigation = $this->generateNavigation($modules);
    }

    public function generateNavigation($modules) {
        $navigation = array();

        foreach ($modules as $module) {
            $moduleConfig = $module->getConfig();
            if (isset($moduleConfig['dashboard'])) {
                $navigation = array_merge($navigation, $moduleConfig['dashboard']);
            }
        }

        usort($navigation, function ($a, $b) {

            if (!isset($a['order'])) {
                return 1;
            }

            if (!isset($b['order'])) {
                return -1;
            }

            if ($a['order'] === $b['order']) {
                return 0;
            }

            return ($a['order'] < $b['order']) ? -1 : 1;
        });

        return $navigation;
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