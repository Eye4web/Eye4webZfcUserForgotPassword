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

        $result = $options->correctEntity($before);

        $this->assertSame($after, $result);
    }
}
