<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Factory\Controller;

use Eye4web\ZfcUser\ForgotPassword\Factory\Controller\ForgotPasswordControllerFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotPasswordControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var ForgotPasswordControllerFactory */
    protected $factory;

    /** @var ControllerManager */
    protected $controllerManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ControllerManager $controllerManager */
        $controllerManager = $this->getMock('Zend\Mvc\Controller\ControllerManager');
        $this->controllerManager = $controllerManager;

        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $controllerManager->expects($this->any())
                          ->method('getServiceLocator')
                          ->willReturn($serviceLocator);

        $factory = new ForgotPasswordControllerFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $serviceLocator = $this->serviceLocator;

        $requestFormMock = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');

        $serviceLocator->expects($this->at(0))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm')
            ->willReturn($requestFormMock);

        $changePasswordMock = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');

        $serviceLocator->expects($this->at(1))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm')
            ->willReturn($changePasswordMock);

        $ForgotPasswordService = $this->getMockBuilder('Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator->expects($this->at(2))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService')
            ->willReturn($ForgotPasswordService);

        $result = $this->factory->createService($this->controllerManager);

        $this->assertInstanceOf('Eye4web\ZfcUser\ForgotPassword\Controller\ForgotPasswordController', $result);
    }
}
