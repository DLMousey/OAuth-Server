<?php

namespace Core\Service;

use DateTime;
use Core\Entity\Application;
use Core\Mapper\ApplicationMapper;
use Zend\Hydrator\ClassMethods;

class ApplicationService
{
    protected $applicationMapper;
    protected $userService;

    public function find($id)
    {
        return $this->getApplicationMapper()->find($id);
    }

    public function create(array $data, string $identity)
    {
        $hydrator = new ClassMethods();
        $application = new Application();

        if(!$user = $this->getUserService()->findByEmail($identity)) {
            return false;
        }

        $hydrator->hydrate($data, $application);

        $application->setClientId(base64_encode(random_bytes(6)));
        $application->setClientSecret(base64_encode(random_bytes(32)));
        $application->setOwner($user);
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

    /**
     * @param UserService $userService
     * @return $this
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
        return $this;
    }

    /**
     * @return UserService
     */
    public function getUserService() : UserService
    {
        return $this->userService;
    }
}
