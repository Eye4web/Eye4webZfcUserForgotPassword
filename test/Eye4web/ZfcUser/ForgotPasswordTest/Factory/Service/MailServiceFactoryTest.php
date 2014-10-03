<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Factory\Service;

use Eye4web\ZfcUser\ForgotPassword\Factory\Service\MailServiceFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var MailServiceFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new MailServiceFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $serviceLocator = $this->serviceLocator;
        $transporterName = 'test';

        $moduleOptions = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptionsInterface');

        $serviceLocator->expects($this->at(0))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions')
            ->willReturn($moduleOptions);

        $moduleOptions->expects($this->once())
            ->method('getMailTransporter')
            ->willReturn($transporterName);

        $mailTransporter = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Service\MailTransporterInterface');

        $serviceLocator->expects($this->at(1))
            ->method('get')
            ->with($transporterName)
            ->willReturn($mailTransporter);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\ZfcUser\ForgotPassword\Service\MailService', $result);
    }
}
