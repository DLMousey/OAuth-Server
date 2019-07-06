<?php

namespace Core\Factory;

use Core\Entity\Scope;
use Core\Service\ScopeService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ScopeServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $repo = $em->getRepository(Scope::class);

        $service = new ScopeService();
        $service->setScopeMapper($repo);

        return $service;
    }
}
