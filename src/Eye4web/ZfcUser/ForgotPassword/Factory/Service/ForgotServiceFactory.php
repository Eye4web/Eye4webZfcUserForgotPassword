<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Service;

use Eye4web\ZfcUser\ForgotPassword\Service\ForgotService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ForgotService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm $requestForm */
        $requestForm = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface $userMapper */
        $userMapper = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapper');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface $tokenMapper */
        $tokenMapper = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapper');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\MailService $mailService */
        $mailService = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Service\MailService');

        return new ForgotService($requestForm, $changePassword, $userMapper, $tokenMapper, $mailService);
    }
}
