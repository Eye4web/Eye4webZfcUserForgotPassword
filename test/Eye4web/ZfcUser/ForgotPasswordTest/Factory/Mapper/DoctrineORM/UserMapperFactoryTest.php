<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Factory\Controller;

use Eye4web\ZfcUser\ForgotPassword\Factory\Mapper\DoctrineORM\UserMapperFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserMapperFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var UserMapperFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {

        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new UserMapperFactory;
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

        $zfcUserModuleOptions = $this->getMock('ZfcUser\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(1))
            ->method('get')
            ->with('zfcuser_module_options')
            ->willReturn($zfcUserModuleOptions);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM\UserMapper', $result);
    }
}
