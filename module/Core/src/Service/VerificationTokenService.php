<?php

namespace Core\Service;

use Core\Entity\Application;
use Core\Entity\User;
use Core\Entity\VerificationToken;
use Core\Mapper\VerificationTokenMapper;
use DateInterval;
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
        return $this->getVerificationTokenMapper()->findOneByToken($token);
    }

    /**
     * @param User $user
     * @return VerificationToken
     * @throws Exception
     */
    public function create(User $user, Application $application)
    {
        $token = new VerificationToken();
        $token->setToken($this->generateToken());
        $token->setDateCreated(new DateTime());
        $token->setExpiryDate($this->generateExpiry());
        $token->setUser($user);

        $this->getVerificationTokenMapper()->persist($token);
        $this->getVerificationTokenMapper()->flush();

        return $token;
    }

    private function generateToken()
    {
        return bin2hex(random_bytes(16));
    }

    private function generateExpiry()
    {
        $dt = new DateTime();
        $dt->add(new DateInterval('PT1H'));

        return $dt;
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
