<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Options;

use Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    /** @var \Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions */
    protected $options;

    public function setUp()
    {
        $options = new ModuleOptions([]);
        $this->options = $options;
    }

    public function testCorrectEntities()
    {
        $options = $this->options;
        $before = 'ZfcUser\Entity\User';
        $after = '\ZfcUser\Entity\User';

        $transporter = 'test';
        $this->options->setMailTransporter($transporter);
        $this->assertSame($transporter, $this->options->getMailTransporter());

        $tokenEntity = '\Eye4web\ZfcUser\ForgotPassword\Entity\TokenInterface';
        $this->options->setTokenEntity($tokenEntity);
        $this->assertSame($tokenEntity, $this->options->getTokenEntity());

        $tokenHours = 24;
        $this->options->setTokenHours($tokenHours);
        $this->assertSame($tokenHours, $this->options->getTokenHours());

        $result = $options->correctEntity($before);

        $this->assertSame($after, $result);
    }
}
