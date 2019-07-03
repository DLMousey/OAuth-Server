<?php

namespace Core\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Storage\SessionStorage;

class SessionManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session_config']);

        $sessionStorage = new SessionStorage();
        $class = $config['session_storage']['type'];
        $sessionStorage = new $class();

        $sessionManager = new SessionManager(
            $sessionConfig,
            $sessionStorage,
            null
        );

        Container::setDefaultManager($sessionManager);
        return $sessionManager;
    }
}
