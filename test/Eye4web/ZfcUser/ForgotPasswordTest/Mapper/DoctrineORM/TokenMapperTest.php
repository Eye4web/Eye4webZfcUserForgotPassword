<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Mapper\DoctrineORM;

use Eye4web\ZfcUser\ForgotPassword\Mapper\DoctrineORM\TokenMapper;
use PHPUnit_Framework_TestCase;

class TokenMapperTest extends PHPUnit_Framework_TestCase
{
    /** @var TokenMapper */
    protected $mapper;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var \Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions */
    protected $options;

    public function setUp()
    {
        /** @var \Doctrine\ORM\EntityManager $objectManager */
        $objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectManager = $objectManager;

        /** @var \Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions $options */
        $options = $this->getMock('\Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions');
        $this->options = $options;

        $mapper = new TokenMapper($objectManager, $options);

        $this->mapper = $mapper;
    }

    public function testFindByUser()
    {
        $userId = 1;
        $tokenEntity = 'Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface';

        /** @var \ZfcUser\Entity\UserInterface $userMock */
        $userMock = $this->getMock('ZfcUser\Entity\UserInterface');

        $userMock->expects($this->once())
            ->method('getId')
            ->willReturn($userId);

        $tokenMock = $this->getMock($tokenEntity);

        $this->options->expects($this->once())
            ->method('getTokenEntity')
            ->willReturn($tokenEntity);

        /** @var \Doctrine\Common\Persistence\ObjectRepository $objectRepository */
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->objectManager->expects($this->once())
            ->method('getRepository')
            ->with($tokenEntity)
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'user' => $userId
            ])
            ->willReturn($tokenMock);

        $result = $this->mapper->findByUser($userMock);

        $this->assertSame($tokenMock, $result);
    }

    public function testFindByToken()
    {
        $token = 'test-token';
        $tokenEntity = 'Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface';
        $data = [];

        /** @var \Doctrine\ORM\QueryBuilder $queryBuilder */
        $queryBuilder = $this->getMockBuilder('\Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $this->options->expects($this->once())
            ->method('getTokenEntity')
            ->willReturn($tokenEntity);

        $this->objectManager->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $queryBuilder->expects($this->once())
            ->method('select')
            ->with('t')
            ->willReturn($queryBuilder);

        $queryBuilder->expects($this->once())
            ->method('from')
            ->with($tokenEntity, 't')
            ->willReturn($queryBuilder);

        $queryBuilder->expects($this->once())
            ->method('where')
            ->with('t.token = :token')
            ->willReturn($queryBuilder);

        $queryBuilder->expects($this->once())
            ->method('andWhere')
            ->with('t.expireDateTime > :current')
            ->willReturn($queryBuilder);

        /** @var \Doctrine\ORM\Query $query */
        $query = $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods(['setParameters', 'getOneOrNullResult'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $query->expects($this->any())
            ->method('setParameters');

        $query->expects($this->any())
            ->method('getOneOrNullResult')
            ->willReturn($data);

        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        $query->expects($this->once())
            ->method('getOneOrNullResult')
            ->willReturn($data);

        $result = $this->mapper->findByToken($token);

        $this->assertSame($data, $result);
    }

    public function testGenerateWithExistingToken()
    {
        $userId = 1;
        $tokenEntity = 'Eye4web\ZfcUser\ForgotPassword\Entity\Token';
        $tokenHours = 24;

        /** @var \ZfcUser\Entity\UserInterface $userMock */
        $userMock = $this->getMock('ZfcUser\Entity\UserInterface');
        $userMock->expects($this->any())
            ->method('getId')
            ->willReturn($userId);

        $tokenMock = $this->getMock($tokenEntity);

        $this->options->expects($this->any())
            ->method('getTokenEntity')
            ->willReturn($tokenEntity);

        $this->options->expects($this->any())
            ->method('getTokenHours')
            ->willReturn($tokenHours);

        /** @var \Doctrine\Common\Persistence\ObjectRepository $objectRepository */
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->objectManager->expects($this->at(0))
            ->method('getRepository')
            ->with($tokenEntity)
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'user' => $userId
            ])
            ->willReturn($tokenMock);

        $this->objectManager->expects($this->at(1))
            ->method('remove')
            ->with($tokenMock);

        $this->objectManager->expects($this->at(2))
            ->method('flush');

        $this->objectManager->expects($this->at(3))
            ->method('persist');

        $this->objectManager->expects($this->at(4))
            ->method('flush');

        $result = $this->mapper->generate($userMock);

        $this->assertInstanceOf('Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface', $result);
    }



    public function testGenerateWithoutExistingToken()
    {
        $userId = 1;
        $tokenEntity = 'Eye4web\ZfcUser\ForgotPassword\Entity\Token';
        $tokenHours = 24;

        /** @var \ZfcUser\Entity\UserInterface $userMock */
        $userMock = $this->getMock('ZfcUser\Entity\UserInterface');
        $userMock->expects($this->any())
            ->method('getId')
            ->willReturn($userId);

        $this->options->expects($this->any())
            ->method('getTokenEntity')
            ->willReturn($tokenEntity);

        $this->options->expects($this->any())
            ->method('getTokenHours')
            ->willReturn($tokenHours);

        /** @var \Doctrine\Common\Persistence\ObjectRepository $objectRepository */
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->objectManager->expects($this->at(0))
            ->method('getRepository')
            ->with($tokenEntity)
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'user' => $userId
            ])
            ->willReturn(null);

        $this->objectManager->expects($this->at(1))
            ->method('persist');

        $this->objectManager->expects($this->at(2))
            ->method('flush');

        $result = $this->mapper->generate($userMock);

        $this->assertInstanceOf('Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface', $result);
    }
}
