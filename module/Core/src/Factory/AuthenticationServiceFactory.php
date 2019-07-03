<?php

namespace Core\Factory;

use Core\Adapter\AuthAdapter;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session as SessionStorage;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sessionManager = $container->get(SessionManager::class);
        $authStorage = new SessionStorage('Zend_Auth', 'session', $sessionManager);

        $authAdapter = new AuthAdapter();
        $authAdapter->setUserService($container->get('core_user_service'));

        return new AuthenticationService($authStorage, $authAdapter);
    }
}
