<?php

namespace Core\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class Application
{
    protected $id;
    protected $name;
    protected $description;
    protected $avatarPath;
    protected $clientId;
    protected $clientSecret;
    protected $dateCreated;
    protected $dateUpdated;
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
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
     * @param string $clientId
     * @return $this
     */
    public function setClientId(string $clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientId() : string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientSecret
     * @return $this
     */
    public function setClientSecret(string $clientSecret)
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret() : string
    {
        return $this->clientSecret;
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
     * @param DateTime|null $dateUpdated
     * @return $this
     */
    public function setDateUpdated(DateTime $dateUpdated = null)
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateUpdated() : DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * @param ArrayCollection $users
     * @return $this
     */
    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers() : ArrayCollection
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function addUser(User $user)
    {
        if(!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user)
    {
        if($this->users->contains($user)) {
            $this->users->remove($user);
        }

        return $this;
    }
}
