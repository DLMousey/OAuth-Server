<?php

namespace Core\Factory;

use Core\Service\AuthenticationManager;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthenticationManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $manager = new AuthenticationManager();
        $manager->setConfig($container->get('config'));
        $manager->setAuthenticationService($container->get(AuthenticationService::class));

        return $manager;
    }
}
