<?php

namespace Eye4web\ZfcUser\ForgotPassword\Service;

use Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface;
use ZfcUser\Entity\UserInterface;

class MailService
{
    /** @var MailTransporterInterface */
    protected $transporter;

    public function __construct($transporter)
    {
        $this->transporter = $transporter;
    }

    public function sendToken(TokenInterface $token, UserInterface $user)
    {
        $options = [
            'to' => $user->getEmail(),
            'subject' => 'Forgot password',
            'template' => 'email/request-password'
        ];

        $variables = [
            'name' => $user->getDisplayName(),
            'token' => $token->getToken(),
        ];

        $this->transporter->send(
            $options,
            $variables
        );
    }
}
