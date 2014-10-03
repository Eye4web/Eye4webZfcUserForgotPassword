<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Factory\Service;

use Eye4web\ZfcUser\ForgotPassword\Factory\Service\ForgotPasswordServiceFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotPasswordServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var ForgotPasswordServiceFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new ForgotPasswordServiceFactory;
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

        $userMapper = $this->getMockBuilder('Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator->expects($this->at(2))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapper')
            ->willReturn($userMapper);

        $tokenMapper = $this->getMockBuilder('Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator->expects($this->at(3))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapper')
            ->willReturn($tokenMapper);

        $mailService = $this->getMockBuilder('Eye4web\ZfcUser\ForgotPassword\Service\MailService')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator->expects($this->at(4))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Service\MailService')
            ->willReturn($mailService);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService', $result);
    }
}
