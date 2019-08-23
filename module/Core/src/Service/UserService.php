<?php

namespace Core\Service;

use Core\Entity\Application;
use Core\Entity\User;
use Core\Entity\VerificationToken;
use Core\Mapper\UserMapper;
use DateTime;
use Zend\Hydrator\ClassMethods;

class UserService
{
    protected $userMapper;

    /**
     * @param int $id
     * @return object|null
     */
    public function find(int $id)
    {
        return $this->getUserMapper()->find($id);
    }

    /**
     * @param string $email
     * @return object|null
     */
    public function findByEmail(string $email)
    {
        return $this->getUserMapper()->findOneBy([
            'email' => $email
        ]);
    }

    public function create(array $data)
    {
        $user = new User();

        if(empty($data['date_of_birth'])) {
            $data['date_of_birth'] = null;
        } else {
            $data['date_of_birth'] = new DateTime($data['date_of_birth']);
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $hydrator = new ClassMethods();
        $hydrator->hydrate($data, $user);

        return $this->getUserMapper()->save($user);
    }

    public function save(User $user)
    {
        $this->getUserMapper()->save($user);
    }

    public function addApplication(User $user, Application $application)
    {
        $user->addApplication($application);
        return $this->getUserMapper()->save($user);
    }

    public function addVerificationToken(User $user, VerificationToken $verificationToken)
    {
        $user->addVerificationToken($verificationToken);
        return $this->getUserMapper()->save($user);
    }

    /**
     * @param UserMapper $userMapper
     * @return $this
     */
    public function setUserMapper(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
        return $this;
    }

    /**
     * @return UserMapper
     */
    public function getUserMapper() : UserMapper
    {
        return $this->userMapper;
    }
}
