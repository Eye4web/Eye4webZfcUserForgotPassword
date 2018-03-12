<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Mapper\DoctrineORM;

use Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM\UserMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface as LegacyFactoryInterface;
use Interop\Container\ContainerInterface;

if (!\interface_exists(FactoryInterface::class)) {
    \class_alias(LegacyFactoryInterface::class, FactoryInterface::class);
}

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

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        return $this->createService($serviceLocator);
    }
}
