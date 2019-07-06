<?php

namespace Core\Service;

use DateTime;
use Core\Entity\AccessToken;
use Core\Entity\Application;
use Core\Entity\User;
use Core\Mapper\AccessTokenMapper;

class AccessTokenService
{
    protected $accessTokenMapper;

    /**
     * @param int $id
     * @return AccessToken|null
     */
    public function find(int $id)
    {
        return $this->getAccessTokenMapper()->find($id);
    }

    /**
     * @param User $user
     * @return array
     */
    public function findByUser(User $user)
    {
        return $this->getAccessTokenMapper()->findByUser($user);
    }

    /**
     * @param string $token
     * @return AccessToken|null
     */
    public function findByToken(string $token)
    {
        return $this->getAccessTokenMapper()->findOneByToken($token);
    }

    public function create(User $user, Application $application)
    {
        if(!$user || !$application) {
            return false;
        }

        $accessToken = new AccessToken();
        $accessToken->setUser($user);
        $accessToken->setToken($this->generateToken());
        $accessToken->setIsRevoked(false);
        $accessToken->setLastUseDate(null);
        $accessToken->setDateCreated(new DateTime());

        $this->getAccessTokenMapper()->save($accessToken);
        $this->getAccessTokenMapper()->flush();

        return $accessToken;
    }

    private function generateToken()
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * @param AccessTokenMapper $accessTokenMapper
     * @return $this
     */
    public function setAccessTokenMapper(AccessTokenMapper $accessTokenMapper)
    {
        $this->accessTokenMapper = $accessTokenMapper;
        return $this;
    }

    /**
     * @return AccessTokenMapper
     */
    public function getAccessTokenMapper() : AccessTokenMapper
    {
        return $this->accessTokenMapper;
    }
}
