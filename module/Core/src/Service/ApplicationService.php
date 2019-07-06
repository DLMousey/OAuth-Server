<?php

namespace Core\Service;

use DateTime;
use RuntimeException;
use Zend\Hydrator\ClassMethods;
use Core\Entity\User;
use Core\Entity\Application;
use Core\Mapper\ApplicationMapper;

class ApplicationService
{
    protected $applicationMapper;
    protected $userService;

    public function findAll(string $identity = null)
    {
        if($identity == null) {
            return [];
        }

        if(!$user = $this->getUserService()->findByEmail($identity)) {
            throw new RuntimeException('Unable to locate user with given identity');
        }

        return $this->getApplicationMapper()->findBy([
            'owner' => $user
        ]);
    }

    public function find($id)
    {
        return $this->getApplicationMapper()->find($id);
    }

    public function findByClientId(string $clientId)
    {
        return $this->getApplicationMapper()->findOneByClientId($clientId);
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

    public function addUser(Application $application, User $user)
    {
        $application->addUser($user);

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
