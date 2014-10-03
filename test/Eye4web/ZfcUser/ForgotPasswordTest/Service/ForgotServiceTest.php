<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Service;

use Eye4web\ZfcUser\ForgotPassword\Service\ForgotPasswordService;
use PHPUnit_Framework_TestCase;

class ForgotPasswordServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var ForgotPasswordService */
    protected $service;

    /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm */
    protected $requestForm;

    /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm */
    protected $changePasswordForm;

    /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface */
    protected $userMapper;

    /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface */
    protected $tokenMapper;

    /** @var \Eye4web\ZfcUser\ForgotPassword\Service\MailService */
    protected $mailService;

    public function setUp()
    {
        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm $requestForm */
        $requestForm = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');
        $this->requestForm = $requestForm;

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm $changePasswordForm */
        $changePasswordForm = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');
        $this->changePasswordForm = $changePasswordForm;

        /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface $userMapper */
        $userMapper = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface');
        $this->userMapper = $userMapper;

        /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface $tokenMapper */
        $tokenMapper = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface');
        $this->tokenMapper = $tokenMapper;

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\MailService $mailService */
        $mailService = $this->getMockBuilder('Eye4web\ZfcUser\ForgotPassword\Service\MailService')
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->mailService = $mailService;

        $service = new ForgotPasswordService(
            $requestForm,
            $changePasswordForm,
            $userMapper,
            $tokenMapper,
            $mailService
        );

        $this->service = $service;
    }

    public function testRequestFormNotValid()
    {
        $data = ['test-data'];

        $this->requestForm->expects($this->at(0))
            ->method('setData')
            ->with($data);

        $this->requestForm->expects($this->at(1))
            ->method('isValid')
            ->willReturn(false);

        $result = $this->service->request($data);

        $this->assertFalse($result);
    }

    public function testRequestFormNoUser()
    {
        $data = ['test-data'];
        $email = 'test@test.dk';

        $this->requestForm->expects($this->at(0))
            ->method('setData')
            ->with($data);

        $this->requestForm->expects($this->at(1))
            ->method('isValid')
            ->willReturn(true);

        $formElement = $this->getMock('Zend\Form\Element\Text');

        $this->requestForm->expects($this->at(2))
            ->method('get')
            ->with('email')
            ->willReturn($formElement);

        $formElement->expects($this->once())
            ->method('getValue')
            ->willReturn($email);

        $this->userMapper->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn(false);

        $result = $this->service->request($data);

        $this->assertTrue($result);
    }

    public function testRequest()
    {
        $data = ['test-data'];
        $email = 'test@test.dk';

        $this->requestForm->expects($this->at(0))
            ->method('setData')
            ->with($data);

        $this->requestForm->expects($this->at(1))
            ->method('isValid')
            ->willReturn(true);

        $formElement = $this->getMock('Zend\Form\Element\Text');

        $this->requestForm->expects($this->at(2))
            ->method('get')
            ->with('email')
            ->willReturn($formElement);

        $formElement->expects($this->once())
            ->method('getValue')
            ->willReturn($email);

        $userMock = $this->getMock('ZfcUser\Entity\UserInterface');
        $tokenMock = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface');

        $this->userMapper->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn($userMock);

        $this->tokenMapper->expects($this->once())
            ->method('generate')
            ->with($userMock)
            ->willReturn($tokenMock);

        $this->mailService->expects($this->once())
            ->method('sendToken')
            ->with($tokenMock, $userMock);

        $result = $this->service->request($data);

        $this->assertTrue($result);
    }

    public function testChangePasswordFormNotValid()
    {
        $data = ['test-data'];
        $userMock = $this->getMock('ZfcUser\Entity\UserInterface');

        $this->changePasswordForm->expects($this->at(0))
            ->method('setData')
            ->with($data);

        $this->changePasswordForm->expects($this->at(1))
            ->method('isValid')
            ->willReturn(false);

        $result = $this->service->changePassword($data, $userMock);

        $this->assertFalse($result);
    }

    public function testChangePassword()
    {
        $data = ['test-data'];
        $userMock = $this->getMock('ZfcUser\Entity\UserInterface');
        $newPassword = 'test';

        $this->changePasswordForm->expects($this->at(0))
            ->method('setData')
            ->with($data);

        $this->changePasswordForm->expects($this->at(1))
            ->method('isValid')
            ->willReturn(true);

        $tokenMock = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface');

        $this->tokenMapper->expects($this->at(0))
            ->method('findByUser')
            ->with($userMock)
            ->willReturn($tokenMock);

        $formElement = $this->getMock('Zend\Form\Element\Password');

        $this->changePasswordForm->expects($this->at(2))
            ->method('get')
            ->with('new_password')
            ->willReturn($formElement);

        $this->userMapper->expects($this->once())
            ->method('changePassword')
            ->with($newPassword, $userMock);

        $formElement->expects($this->once())
            ->method('getValue')
            ->willReturn($newPassword);

        $this->tokenMapper->expects($this->at(1))
            ->method('remove')
            ->with($tokenMock);

        $result = $this->service->changePassword($data, $userMock);

        $this->assertTrue($result);
    }

    public function testGetUserFromTokenNoToken()
    {
        $token = 'test-token';

        $this->tokenMapper->expects($this->once())
            ->method('findByToken')
            ->with($token)
            ->willReturn(false);

        $result = $this->service->getUserFromToken($token);

        $this->assertFalse($result);
    }

    public function testGetUserFromToken()
    {
        $token = 'test-token';
        $tokenMock = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface');
        $userMock = $this->getMock('ZfcUser\Entity\UserInterface');
        $userId = 1;

        $tokenMock->expects($this->once())
            ->method('getUser')
            ->willReturn($userId);

        $this->tokenMapper->expects($this->once())
            ->method('findByToken')
            ->with($token)
            ->willReturn($tokenMock);

        $this->userMapper->expects($this->once())
            ->method('findById')
            ->with($userId)
            ->willReturn($userMock);

        $result = $this->service->getUserFromToken($token);

        $this->assertSame($userMock, $result);
    }
}
