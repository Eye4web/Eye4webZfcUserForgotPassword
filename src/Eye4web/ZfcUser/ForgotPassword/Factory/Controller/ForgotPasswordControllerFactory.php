<?php

namespace Eye4web\ZfcUser\ForgotPassword\Factory\Controller;

use Eye4web\ZfcUser\ForgotPassword\Controller\ForgotPasswordController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotPasswordControllerFactory implements FactoryInterface
{
    /**
     * Create controller
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return ForgotPasswordController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $controllerManager;

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm $requestForm */
        $requestForm = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService $forgotPasswordService */
        $forgotPasswordService = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService');

        return new ForgotPasswordController($requestForm, $changePassword, $forgotPasswordService);
    }

    public function __invoke(\Psr\Container\ContainerInterface $container, $requestedName, array $options = NULL)
    {
        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm $requestForm */
        $requestForm = $container->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $container->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService $forgotPasswordService */
        $forgotPasswordService = $container->get('Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService');

        return new ForgotPasswordController($requestForm, $changePassword, $forgotPasswordService);
    }
}
