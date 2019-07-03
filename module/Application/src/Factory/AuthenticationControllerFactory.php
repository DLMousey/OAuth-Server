<?php

namespace Application\Factory;

use Application\Controller\AuthenticationController;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthenticationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new AuthenticationController();
        $controller->setUserService($container->get('core_user_service'));
        $controller->setAuthenticationManager($container->get('core_authentication_manager'));
        $controller->setAuthenticationService($container->get(AuthenticationService::class));

        return $controller;
    }
}
