<?php


namespace App\Entity\Administrator;


use App\Component\Bcrypt;
use App\Entity\Entity;
use DI\Annotation\Inject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Administrator\AdministratorRepository")
 * @ORM\Table(name="administrator")
 */
class Administrator extends Entity
{
    public const ADMINISTRATOR_STATUS_ACTIVE = 1;
    public const ADMINISTRATOR_STATUS_INACTIVE = 0;

    /**
     * @ORM\Column(length=200)
     */
    protected $email;

    /**
     * @ORM\Column(length=200)
     */
    protected $name;

    /**
     * @ORM\Column(length=200)
     */
    protected $password;

    /**
     * @ORM\Column(length=150)
     */
    protected $user;

    /**
     * @ORM\Column(length=250)
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
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
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



    public function isAuthentic($password): bool
    {
        return Bcrypt::check($password, $this->getPassword());
    }





}