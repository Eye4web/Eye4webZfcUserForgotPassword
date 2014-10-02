<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Mapper\DoctrineORM;

use Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM\UserMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $objectManager */
        $objectManager = $serviceLocator->get('objectManager');

        /** @var \ZfcUser\Options\ModuleOptions $zfcUserModuleOptions */
        $zfcUserModuleOptions = $serviceLocator->get('zfcuser_module_options');

        return new UserMapper($objectManager, $zfcUserModuleOptions);
    }
}
