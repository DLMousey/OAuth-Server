<?php

namespace Core\Service;

use DateTime;
use Core\Entity\Application;
use Core\Mapper\ApplicationMapper;
use Zend\Hydrator\ClassMethods;

class ApplicationService
{
    protected $applicationMapper;

    public function create(array $data)
    {
        $hydrator = new ClassMethods();
        $application = new Application();

        $hydrator->hydrate($data, $application);

        $application->setClientId(base64_encode(random_bytes(6)));
        $application->setClientSecret(base64_encode(random_bytes(32)));
        $application->setDateCreated(new DateTime());

        $this->getApplicationMapper()->persist($application);
        $this->getApplicationMapper()->flush();

        return $application;
    }

    /**
     * @param ApplicationMapper $applicationMapper
     * @return $this
     */
    public function setApplicationMapper(ApplicationMapper $applicationMapper)
    {
        $this->applicationMapper = $applicationMapper;
        return $this;
    }

    /**
     * @return ApplicationMapper
     */
    public function getApplicationMapper() : ApplicationMapper
    {
        return $this->applicationMapper;
    }
}
