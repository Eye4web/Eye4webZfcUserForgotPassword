<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Controller;

use Eye4web\ZfcUser\ForgotPassword\Controller\ForgotController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotControllerFactory implements FactoryInterface
{
    /**
     * Create controller
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return ForgotController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $controllerManager->getServiceLocator();

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm $requestForm */
        $requestForm = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\ForgotService $forgotService */
        $forgotService = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Service\ForgotService');

        return new ForgotController($requestForm, $changePassword, $forgotService);
    }
}
