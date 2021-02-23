<?php

namespace App\Entity\User;

use App\Component\Bcrypt;
use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\user\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends Entity
{
    public const USER_STATUS_ACTIVE = 1;
    public const USER_STATUS_INACTIVE = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Company",inversedBy="users")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\Column(length=150)
     */
    protected $email;

    /**
     * @ORM\Column(length=150)
     */
    protected $name;

    /**
     * @ORM\Column(length=60)
     */
    protected $password;

    /**
     * @ORM\Column(length=60)
     */
    protected $hash;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = Bcrypt::hash($password);
    }

    /**
     * @param $password
     * @return bool
     */
    public function isAuthentic($password): bool
    {
        return Bcrypt::check($password, $this->getPassword());
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company): void
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }




}
