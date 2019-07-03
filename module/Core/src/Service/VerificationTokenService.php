<?php

namespace Core\Service;

use Core\Entity\User;
use Core\Entity\VerificationToken;
use Core\Mapper\VerificationTokenMapper;
use DateTime;
use Exception;

class VerificationTokenService
{
    protected $verificationTokenMapper;

    /**
     * @param string $token
     * @return VerificationToken|null
     */
    public function findByToken(string $token)
    {
        return $this->getVerificationTokenMapper()->findOneByCode($token);
    }

    /**
     * @param User $user
     * @param array $data
     * @return VerificationToken
     * @throws Exception
     */
    public function create(User $user, array $data)
    {
        $token = new VerificationToken();
        $token->setToken($this->generateToken());
        $token->setDateCreated(new DateTime());
        $token->setExpiryDate($this->generateExpiry());
        $token->setUser($user);

        return $this->getVerificationTokenMapper()->save($token);
    }

    private function generateToken()
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * @param VerificationTokenMapper $verificationTokenMapper
     * @return $this
     */
    public function setVerificationTokenMapper(VerificationTokenMapper $verificationTokenMapper)
    {
        $this->verificationTokenMapper = $verificationTokenMapper;
        return $this;
    }

    /**
     * @return VerificationTokenMapper
     */
    public function getVerificationTokenMapper() : VerificationTokenMapper
    {
        return $this->verificationTokenMapper;
    }
}
