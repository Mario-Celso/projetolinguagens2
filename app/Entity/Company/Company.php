<?php


namespace App\Entity\Company;

use App\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Company\CompanyRepository")
 * @ORM\Table(name="companies")
 */
class Company extends Entity
{
    public const COMPANY_STATUS_ACTIVE = 1;
    public const COMPANY_STATUS_INACTIVE = 0;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Customer\Customer", mappedBy="company")
     */
    private Collection $customers;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\SafeCompany\SafeCompany", mappedBy="company")
     */
    private Collection $safe_companies;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\InsuranceClaim\InsuranceClaim", mappedBy="company")
     */
    private Collection $insurance_claim;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Policy\Policy", mappedBy="company")
     */
    private Collection $policy;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Proposal\Proposal",mappedBy="company")
     */
    private Collection $proposal;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\User\User", mappedBy="company")
     */
    private Collection $users;



    /**
     * @ORM\Column(length=200)
     */
    protected $name;

    /**
     * @ORM\Column(length=100)
     */
    protected $document;

    /**
     * @ORM\Column(length=60)
     */
    protected $hash;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status;

    public function __construct()
    {
        parent::__construct();
        $this->users = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->insurance_claim = new ArrayCollection();
        $this->policy = new ArrayCollection();
        $this->proposal = new ArrayCollection();
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
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument($document): void
    {
        $this->document = $document;
    }

    /**
     * @return Collection
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    /**
     * @param Collection $customers
     */
    public function setCustomers(Collection $customers): void
    {
        $this->customers = $customers;
    }

    /**
     * @return Collection
     */
    public function getInsuranceClaim(): Collection
    {
        return $this->insurance_claim;
    }

    /**
     * @param Collection $insurance_claim
     */
    public function setInsuranceClaim(Collection $insurance_claim): void
    {
        $this->insurance_claim = $insurance_claim;
    }

    /**
     * @return Collection
     */
    public function getPolicy(): Collection
    {
        return $this->policy;
    }

    /**
     * @param Collection $policy
     */
    public function setPolicy(Collection $policy): void
    {
        $this->policy = $policy;
    }

    /**
     * @return Collection
     */
    public function getProposal(): Collection
    {
        return $this->proposal;
    }

    /**
     * @param Collection $proposal
     */
    public function setProposal(Collection $proposal): void
    {
        $this->proposal = $proposal;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     */
    public function setUsers(Collection $users): void
    {
        $this->users = $users;
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

    /**
     * @return Collection
     */
    public function getSafeCompanies(): Collection
    {
        return $this->safe_companies;
    }

    /**
     * @param Collection $safe_companies
     */
    public function setSafeCompanies(Collection $safe_companies): void
    {
        $this->safe_companies = $safe_companies;
    }
}