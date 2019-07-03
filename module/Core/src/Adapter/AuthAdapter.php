<?php

namespace Core\Adapter;

use Core\Service\UserService;
use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class AuthAdapter implements AdapterInterface
{
    protected $email;
    protected $password;
    protected $userService;

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        if(!$user = $this->getUserService()->findByEmail($this->getEmail())) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials']
            );
        }

        if(password_verify($this->getPassword(), $user->getPassword())) {
            return new Result(
                Result::SUCCESS,
                $this->getEmail(),
                ['Authenticated successfully']
            );
        }

        return new Result(
            Result::FAILURE_CREDENTIAL_INVALID,
            null,
            ['Invalid credentials']
        );
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
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
