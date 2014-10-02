<?php

namespace Eye4web\ZfcUser\ForgotPassword;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '../../../../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return include __DIR__ . '../../../../../config/module.service.php';
    }

    public function getControllerConfig()
    {
        return include __DIR__ . '../../../../../config/module.controller.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '../../../../../src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
