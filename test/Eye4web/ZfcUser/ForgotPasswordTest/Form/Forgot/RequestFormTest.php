<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Form\Forgot;

use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm;
use PHPUnit_Framework_TestCase;

class RequestFormTest extends PHPUnit_Framework_TestCase
{
    /** @var RequestForm */
    protected $form;

    public function setUp()
    {
        /** @var RequestForm $form */
        $form = new RequestForm;

        $this->form = $form;
    }

    public function testHasElements()
    {
        $form = $this->form;

        $this->assertTrue($form->has('email'));
        $this->assertTrue($form->has('csrf'));
        $this->assertTrue($form->has('submit'));
    }
}
