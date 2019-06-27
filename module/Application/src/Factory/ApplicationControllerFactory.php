<?php

namespace Application\Factory;

use Application\Controller\ApplicationController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ApplicationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new ApplicationController();
        $controller->setApplicationService($container->get('core_application_service'));

        return $controller;
    }
}
