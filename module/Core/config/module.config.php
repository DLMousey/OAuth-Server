<?php

namespace Core;

use Core\Factory\ApplicationServiceFactory;
use Doctrine\ORM\Mapping\Driver\XmlDriver;

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
            'core_application_service' => ApplicationService::class
        ],
        'factories' => [
            ApplicationService::class => ApplicationServiceFactory::class
        ]
    ]
];
