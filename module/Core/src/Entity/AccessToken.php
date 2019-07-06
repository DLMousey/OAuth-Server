<?php

namespace Core\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class AccessToken
{
    protected $id;
    protected $token;
    protected $dateCreated;
    protected $isRevoked;
    protected $lastUseDate;
    protected $user;
    protected $scopes;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
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
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken() : string
    {
        return $this->token;
    }

    /**
     * @param DateTime $dateCreated
     * @return $this
     */
    public function setDateCreated(DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateCreated() : DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param bool $isRevoked
     * @return $this
     */
    public function setIsRevoked(bool $isRevoked = false)
    {
        $this->isRevoked = $isRevoked;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsRevoked() : bool
    {
        return $this->isRevoked;
    }

    /**
     * @param DateTime $lastUseDate
     * @return $this
     */
    public function setLastUseDate(DateTime $lastUseDate = null)
    {
        $this->lastUseDate = $lastUseDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastUseDate() : DateTime
    {
        return $this->lastUseDate;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * @param array $scopes
     * @return $this
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @param Scope $scope
     * @return $this
     */
    public function addScope(Scope $scope)
    {
        if(!$this->scopes->contains($scope)) {
            $this->scopes->add($scope);
        }

        return $this;
    }

    /**
     * @param Scope $scope
     * @return $this
     */
    public function removeScope(Scope $scope)
    {
        if($this->scopes->contains($scope)) {
            $this->scopes->remove($scope);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }
}
