<?php

return [
    'aliases' => [
        'objectManager' => 'Doctrine\ORM\EntityManager',
    ],

    'invokables' => [
        'Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm' => 'Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm',
        'Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm' => 'Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm',
    ],

    'factories' => [
        'Eye4web\ZfcUser\ForgotPassword\Service\ForgotService' => 'Eye4web\ZfcUser\ForgotPassword\Factory\Service\ForgotServiceFactory',
        'Eye4web\ZfcUser\ForgotPassword\Service\MailService' => 'Eye4web\ZfcUser\ForgotPassword\Factory\Service\MailServiceFactory',

        'Eye4web\ZfcUser\ForgotPassword\Options\ModuleOptions' => 'Eye4web\ZfcUser\ForgotPassword\Factory\Options\ModuleOptionsFactory',

        'Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapper' => 'Eye4web\ZfcUser\ForgotPassword\Factory\Mapper\DoctrineORM\UserMapperFactory',
        'Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapper' => 'Eye4web\ZfcUser\ForgotPassword\Factory\Mapper\DoctrineORM\TokenMapperFactory',
    ]
];
