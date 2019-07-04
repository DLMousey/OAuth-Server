<?php


namespace Application\Factory;


use Application\Controller\OAuthController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class OAuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new OAuthController();
        $controller->setApplicationService($container->get('core_application_service'));
        $controller->setVerificationTokenService($container->get('core_verification_token_service'));
        $controller->setUserService($container->get('core_user_service'));

        return $controller;
    }
}
