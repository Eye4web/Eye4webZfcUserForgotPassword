<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Options;

use Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Create options
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $boardConfig = [];

        if (isset($config['e4w']['forgot-password'])) {
            $boardConfig = $config['e4w']['forgot-password'];
        }

        $options = new ModuleOptions($boardConfig);

        return $options;
    }
}
