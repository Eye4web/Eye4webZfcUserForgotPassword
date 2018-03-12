<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Service;

use Eye4web\ZfcUser\ForgotPassword\Service\MailService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface as LegacyFactoryInterface;
use Interop\Container\ContainerInterface;

if (!\interface_exists(FactoryInterface::class)) {
    \class_alias(LegacyFactoryInterface::class, FactoryInterface::class);
}

class MailServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return MailService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\MailTransporterInterface $mailTransporter */
        $mailTransporter = $serviceLocator->get($moduleOptions->getMailTransporter());

        return new MailService($mailTransporter);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        return $this->createService($serviceLocator);
    }
}
