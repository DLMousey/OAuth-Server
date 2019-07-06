<?php

namespace Core\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    protected $id;
    protected $username;
    protected $firstName;
    protected $lastName;
    protected $password;
    protected $email;
    protected $dateOfBirth;
    protected $avatarPath;
    protected $verificationTokens;
    protected $accessTokens;
    protected $applications;

    public function __construct()
    {
        $this->verificationTokens = new ArrayCollection();
        $this->accessTokens = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName() : string
    {
        return $this->lastName;
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
     * @param DateTime $dateOfBirth
     * @return $this
     */
    public function setDateOfBirth(DateTime $dateOfBirth = null)
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateOfBirth() : DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string $avatarPath
     * @return $this
     */
    public function setAvatarPath(string $avatarPath)
    {
        $this->avatarPath = $avatarPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatarPath() : string
    {
        return $this->avatarPath;
    }

    /**
     * @param ArrayCollection $verificationTokens
     * @return $this
     */
    public function setVerificationTokens(ArrayCollection $verificationTokens)
    {
        $this->verificationTokens = $verificationTokens;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getVerificationTokens() : ArrayCollection
    {
        return $this->verificationTokens;
    }

    /**
     * @param $verificationToken
     * @return $this
     */
    public function addVerificationToken(VerificationToken $verificationToken)
    {
        if(!$this->verificationTokens->contains($verificationToken)) {
            $this->verificationTokens->add($verificationToken);
        }

        return $this;
    }

    /**
     * @param $verificationToken
     * @return $this
     */
    public function removeVerificationToken(VerificationToken $verificationToken)
    {
        if($this->verificationTokens->contains($verificationToken)) {
            $this->verificationTokens->remove($verificationToken);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $accessTokens
     * @return $this
     */
    public function setAccessTokens(ArrayCollection $accessTokens)
    {
        $this->refreshTokens = $accessTokens;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAccessTokens() : ArrayCollection
    {
        return $this->accessTokens;
    }

    /**
     * @param AccessToken $accessToken
     * @return $this
     */
    public function addAccessToken(AccessToken $accessToken)
    {
        if(!$this->accessTokens->contains($accessToken)) {
            $this->accessTokens->add($accessToken);
        }

        return $this;
    }

    /**
     * @param AccessToken $accessToken
     * @return $this
     */
    public function removeAccessToken(AccessToken $accessToken)
    {
        if($this->accessTokens->contains($accessToken)) {
            $this->accessTokens->remove($accessToken);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $applications
     * @return $this
     */
    public function setApplications(ArrayCollection $applications)
    {
        $this->applications = $applications;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getApplications() : ArrayCollection
    {
        return $this->applications;
    }

    /**
     * @param Application $application
     * @return $this
     */
    public function addApplication(Application $application)
    {
        if(!$this->applications->contains($application)) {
            $this->applications->add($application);
        }

        return $this;
    }

    /**
     * @param Application $application
     * @return $this
     */
    public function removeApplication(Application $application)
    {
        if($this->applications->contains($application)) {
            $this->applications->remove($application);
        }

        return $this;
    }
}
