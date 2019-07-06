<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\ApplicationController;
use Application\Controller\OAuthController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application-list' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/applications',
                    'defaults' => [
                        'controller' => Controller\ApplicationController::class,
                        'action' => 'applicationList'
                    ]
                ]
            ],
            'application-detail' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/applications/:id',
                    'defaults' => [
                        'controller' => Controller\ApplicationController::class,
                        'action' => 'applicationDetail'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'edit' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/edit',
                            'defaults' => [
                                'controller' => Controller\ApplicationController::class,
                                'action' => 'applicationEdit'
                            ]
                        ]
                    ]
                ]
            ],
            'application-create' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/applications/create',
                    'defaults' => [
                        'controller' => Controller\ApplicationController::class,
                        'action' => 'applicationCreate'
                    ],
                ]
            ],
            'register' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/register',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action' => 'register'
                    ]
                ]
            ],
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action' => 'login'
                    ]
                ]
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action' => 'logout'
                    ]
                ]
            ],
            'oauth' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/oauth',
                    'defaults' => [
                        'controller' => Controller\OAuthController::class,
                        'action' => 'userConsent'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'consent-granted' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/granted',
                            'verb' => 'get',
                            'defaults' => [
                                'controller' => Controller\OAuthController::class,
                                'action' => 'userConsentGrant'
                            ]
                        ]
                    ],
                    'consent-granted-callback' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/granted-callback',
                            'verb' => 'post',
                            'defaults' => [
                                'controller' => Controller\OAuthController::class,
                                'action' => 'userConsentGrantCallback'
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ApplicationController::class => Factory\ApplicationControllerFactory::class,
            Controller\AuthenticationController::class => Factory\AuthenticationControllerFactory::class,
            Controller\OAuthController::class => Factory\OAuthControllerFactory::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'session_containers' => [
        'Zend_Auth'
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive'
        ],
        'controllers' => [
            ApplicationController::class => [
                [
                    'actions' => [
                        'applicationList',
                        'applicationDetail',
                        'applicationForm'
                    ],
                    'allow' => '@'
                ]
            ],
            OAuthController::class => [
                [
                    'actions' => [
                        'userConsent',
                        'userConsentGrant',
                    ],
                    'allow' => '@'
                ],
                [
                    'actions' => [
                        'userConsentGrantCallback',
                    ],
                    'allow' => '*'
                ]
            ]
        ]
    ]
];
