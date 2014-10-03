<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Form\Forgot;

use Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm;
use PHPUnit_Framework_TestCase;

class ChangePasswordFormTest extends PHPUnit_Framework_TestCase
{
    /** @var ChangePasswordForm */
    protected $form;

    public function setUp()
    {
        /** @var ChangePasswordForm $form */
        $form = new ChangePasswordForm;

        $this->form = $form;
    }

    public function testHasElements()
    {
        $form = $this->form;

        $this->assertTrue($form->has('new_password'));
        $this->assertTrue($form->has('confirm_new_password'));
        $this->assertTrue($form->has('csrf'));
        $this->assertTrue($form->has('submit'));
        $this->assertTrue($form->getInputFilter()->has('new_password'));
        $this->assertTrue($form->getInputFilter()->has('confirm_new_password'));
    }
}
