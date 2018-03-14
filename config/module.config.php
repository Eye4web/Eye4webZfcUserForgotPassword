<?php
return [
    'router' => [
        'routes' => [
            'e4w' => [
                'type' => \Zend\Router\Http\Literal::class,
                'options' => [
                    'route' => '/'
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'zfc-user-forgot-password' => [
                        'type' => \Zend\Router\Http\Literal::class,
                        'options' => [
                            'route' => 'forgot-password',
                            'defaults' => [
                                'controller' => 'Eye4web\ZfcUser\ForgotPassword\Controller\ForgotPasswordController',
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'change-password' => [
                                'type' => \Zend\Router\Http\Segment::class,
                                'options' => [
                                    'route' => '/change-password/:token',
                                    'defaults' => [
                                        'controller' => 'Eye4web\ZfcUser\ForgotPassword\Controller\ForgotPasswordController',
                                        'action'     => 'changePassword',
                                    ],
                                ],
                            ],
                        ]
                    ],
                ]
            ]
        ],
    ],
    'doctrine' => [
        'driver' => [
            'eye4web_zfcuser_forgotpassword_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => [
                    __DIR__ . '/../src/Eye4web/ZfcUser/ForgotPassword/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Eye4web\\ZfcUser\\ForgotPassword' => 'eye4web_zfcuser_forgotpassword_driver'
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
