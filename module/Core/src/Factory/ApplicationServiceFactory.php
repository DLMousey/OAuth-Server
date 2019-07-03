<?php


namespace Core\Factory;


use Core\Entity\Application;
use Core\Service\ApplicationService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ApplicationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $repo = $em->getRepository(Application::class);

        $service = new ApplicationService();
        $service->setApplicationMapper($repo);
        $service->setUserService($container->get('core_user_service'));

        return $service;
    }
}
