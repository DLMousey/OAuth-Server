<?php

namespace Core;

use Core\Factory;
use Core\Service;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Zend\Authentication\AuthenticationService;
use Zend\Session\SessionManager;

return [
    'doctrine' => [
        'driver' => [
            'core_driver' => [
                'class' => XmlDriver::class,
                'paths' => __DIR__ . '/xml/entities'
            ],
            'orm_default' => [
                'drivers' => [
                    'Core\Entity' => 'core_driver'
                ]
            ]
        ]
    ],
    'service_manager' => [
        'aliases' => [
            'core_application_service' => Service\ApplicationService::class,
            'core_user_service' => Service\UserService::class,
            'core_authentication_manager' => Service\AuthenticationManager::class,
            'core_verification_token_service' => Service\VerificationTokenService::class,
            'core_access_token_service' => Service\AccessTokenService::class,
            'core_scope_service' => Service\ScopeService::class
        ],
        'factories' => [
            Service\ApplicationService::class => Factory\ApplicationServiceFactory::class,
            Service\UserService::class => Factory\UserServiceFactory::class,
            Service\AuthenticationManager::class => Factory\AuthenticationManagerFactory::class,
            Service\VerificationTokenService::class => Factory\VerificationTokenServiceFactory::class,
            Service\AccessTokenService::class => Factory\AccessTokenServiceFactory::class,
            Service\ScopeService::class => Factory\ScopeServiceFactory::class,
            AuthenticationService::class => Factory\AuthenticationServiceFactory::class,
            SessionManager::class => Factory\SessionManagerFactory::class
        ]
    ]
];
