<?php

namespace Core\Factory;

use Core\Entity\VerificationToken;
use Core\Service\VerificationTokenService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class VerificationTokenServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $repo = $em->getRepository(VerificationToken::class);

        $service = new VerificationTokenService();
        $service->setVerificationTokenMapper($repo);

        return $service;
    }
}
