<?php

use Core\Types\ClientSecret;

if(!isset($dbParams))
    require 'database.local.php';

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'types' => [
                    ClientSecret::NAME => ClientSecret::class
                ]
            ]
        ],
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => [
                    'host' => $dbParams['hostname'],
                    'port' => $dbParams['port'],
                    'user' => $dbParams['username'],
                    'password' => $dbParams['password'],
                    'dbname' => $dbParams['database']
                ],
                'doctrine_type_mappings' => [
                    'clientsecret' => 'clientsecret'
                ]
            ]
        ]
    ]
];
