<?php

namespace Core\Factory;

use Core\Entity\User;
use Core\Service\UserService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $repo = $em->getRepository(User::class);

        $service = new UserService();
        $service->setUserMapper($repo);

        return $service;
    }
}
