<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Factory\Controller;

use Eye4web\ZfcUser\ForgotPassword\Factory\Mapper\DoctrineORM\TokenMapperFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class TokenMapperFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var TokenMapperFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {

        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new TokenMapperFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceLocator->expects($this->at(0))
            ->method('get')
            ->with('objectManager')
            ->willReturn($objectManager);

        $moduleOptions = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(1))
            ->method('get')
            ->with('Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions')
            ->willReturn($moduleOptions);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM\TokenMapper', $result);
    }
}
