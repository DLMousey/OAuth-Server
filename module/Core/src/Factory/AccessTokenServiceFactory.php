<?php

namespace Core\Factory;

use Core\Entity\AccessToken;
use Core\Service\AccessTokenService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AccessTokenServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $repo = $em->getRepository(AccessToken::class);

        $service = new AccessTokenService();
        $service->setAccessTokenMapper($repo);

        return $service;
    }
}
