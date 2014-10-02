<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Mapper\DoctrineORM;

use Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM\UserMapper;
use PHPUnit_Framework_TestCase;

class UserMapperTest extends PHPUnit_Framework_TestCase
{
    /** @var UserMapper */
    protected $mapper;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var \ZfcUser\Options\ModuleOptions*/
    protected $options;

    public function setUp()
    {
        /** @var \Doctrine\ORM\EntityManager $objectManager */
        $objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectManager = $objectManager;

        /** @var \ZfcUser\Options\ModuleOptions $options */
        $options = $this->getMock('\ZfcUser\Options\ModuleOptions');
        $this->options = $options;

        $mapper = new UserMapper($objectManager, $options);

        $this->mapper = $mapper;
    }

    public function testFindById()
    {
        $userId = 1;

        $userEntity = 'ZfcUser\Entity\UserInterface';

        $this->options->expects($this->once())
            ->method('getUserEntityClass')
            ->willReturn($userEntity);

        /** @var \ZfcUser\Entity\UserInterface $userMock */
        $userMock = $this->getMock($userEntity);

        /** @var \Doctrine\Common\Persistence\ObjectRepository $objectRepository */
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->objectManager->expects($this->once())
            ->method('getRepository')
            ->with($userEntity)
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
            ->method('find')
            ->with($userId)
            ->willReturn($userMock);

        $result = $this->mapper->findById($userId);

        $this->assertSame($userMock, $result);
    }

    public function testFindByEmail()
    {
        $email = 'test@test.dk';

        $userEntity = 'ZfcUser\Entity\UserInterface';

        $this->options->expects($this->once())
            ->method('getUserEntityClass')
            ->willReturn($userEntity);

        /** @var \ZfcUser\Entity\UserInterface $userMock */
        $userMock = $this->getMock($userEntity);

        /** @var \Doctrine\Common\Persistence\ObjectRepository $objectRepository */
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->objectManager->expects($this->once())
            ->method('getRepository')
            ->with($userEntity)
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => $email])
            ->willReturn($userMock);

        $result = $this->mapper->findByEmail($email);

        $this->assertSame($userMock, $result);
    }

    public function testChangePassword()
    {
        $cost = 5;

        $this->options->expects($this->once())
            ->method('getPasswordCost')
            ->willReturn($cost);

        /** @var \ZfcUser\Entity\User $userMock */
        $userMock = $this->getMock('ZfcUser\Entity\User');

        $userMock->expects($this->once())
            ->method('setPassword');

        $this->objectManager->expects($this->at(0))
            ->method('persist');

        $this->objectManager->expects($this->at(1))
            ->method('flush');

        $result = $this->mapper->changePassword('password', $userMock);

        $this->assertInstanceOf('\ZfcUser\Entity\UserInterface', $result);
    }
}
