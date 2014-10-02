<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Service;

use Eye4web\ZfcUser\ForgotPassword\Service\MailService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
}
