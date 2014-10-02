<?php
namespace Eye4web\ZfcUser\ForgotPassword\Form\Forgot;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class ChangePasswordForm extends Form implements InputFilterProviderInterface
{
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('change-password');

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'new_password',
            'type'  => 'Zend\Form\Element\Password',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'type' => 'text',
                'label' => 'New password',

            ],
        ]);

        $this->add([
            'name' => 'confirm_new_password',
            'type'  => 'Zend\Form\Element\Password',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'type' => 'text',
                'label' => 'Confirm new password',

            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => [
                'type' => 'submit',
                'class' => 'btn btn-success',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'new_password',
                'required' => true,
                'validators' => [
                    [
                        'name'    => '\Zend\Validator\StringLength',
                        'options' => [
                            'min' => '5',
                        ],
                        'messages' => [
                            \Zend\Validator\StringLength::TOO_SHORT => 'Your new password must be at least 5 characters long',
                        ]
                    ],
                ],
            ],
            [
                'name' => 'confirm_new_password',
                'required' => true,
                'validators' => [
                    [
                        'name'    => '\Zend\Validator\Identical',
                        'options' => [
                            'token' => 'new_password',
                        ],
                        'messages' => [
                            \Zend\Validator\Identical::NOT_SAME => 'The two passswords does not match',
                        ]
                    ],
                ],
            ],
        ];
    }
}
