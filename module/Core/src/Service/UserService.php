<?php

namespace Core\Service;

use Core\Mapper\UserMapper;

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
