<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Service;

use Eye4web\ZfcUser\ForgotPassword\Service\MailService;
use PHPUnit_Framework_TestCase;

class MailServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var MailService */
    protected $service;

    /** @var \Eye4web\ZfcUser\ForgotPassword\Service\MailTransporterInterface */
    protected $transporter;

    public function setUp()
    {
        $transporter = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Service\MailTransporterInterface');
        $this->transporter = $transporter;

        $service = new MailService($transporter);

        $this->service = $service;
    }

    public function testSendToken()
    {
        $tokenMock = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface');
        $userMock = $this->getMock('ZfcUser\Entity\User');

        $email = 'test@test.dk';
        $displayName = 'Test';
        $token = 'test-token';


        $options = [
            'to' => $email,
            'subject' => 'Forgot password test',
            'template' => 'email/request-password'
        ];

        $variables = [
            'name' => $displayName,
            'token' => $token,
        ];

        $userMock->expects($this->at(0))
            ->method('getEmail')
            ->willReturn($email);

        $userMock->expects($this->at(1))
            ->method('getDisplayName')
            ->willReturn($displayName);

        $tokenMock->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $this->transporter->expects($this->once())
            ->method('send')
            ->with($options, $variables);

        $this->service->sendToken($tokenMock, $userMock);
    }
}
