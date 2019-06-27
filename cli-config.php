<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/autoload/database.local.php';

use Core\Types\ClientSecret;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Mapping\Driver\XmlDriver;


$driver = new XmlDriver(__DIR__ . '/module/Core/config/xml/entities');

$config = Setup::createconfiguration(false);
$config->setMetadataDriverImpl($driver);

$entityManager = EntityManager::create($cliParams, $config);

Type::addType(ClientSecret::NAME, ClientSecret::class);

return ConsoleRunner::createHelperSet($entityManager);
