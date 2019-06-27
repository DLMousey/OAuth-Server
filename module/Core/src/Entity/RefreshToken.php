<?php

namespace Core\Entity;

use DateTime;

class RefreshToken
{
    protected $id;
    protected $token;
    protected $dateCreated;
    protected $expiryDate;
    protected $lastUseDate;
    protected $user;

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
     * @param DateTime $lastUseDate
     * @return $this
     */
    public function setLastUseDate(DateTime $lastUseDate)
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
}
