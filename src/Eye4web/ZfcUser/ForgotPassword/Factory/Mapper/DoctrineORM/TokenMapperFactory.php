<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Mapper\DoctrineORM;

use Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM\TokenMapper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TokenMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TokenMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $objectManager */
        $objectManager = $serviceLocator->get('objectManager');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions');

        return new TokenMapper($objectManager, $moduleOptions);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        return $this->createService($container);
    }
}
