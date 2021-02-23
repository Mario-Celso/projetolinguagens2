<?php

namespace App\Entity\Policy;

use App\Entity\Entity;
use App\Entity\Proposal\Proposal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Policy\PolicyRepository")
 * @ORM\Table(name="policies")
 */
class Policy extends Entity
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Company",inversedBy="policy")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer", inversedBy="policies")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Policy\PolicyDocument", mappedBy="policies")
     */
    private Collection $documents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InsuranceClaim\InsuranceClaim", mappedBy="policy")
     */
    private Collection $insurance_claims;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proposal\Proposal", inversedBy="policies")
     * @ORM\JoinColumn(name="policy_id", referencedColumnName="id")
     */
    private Proposal $proposal;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\SafeCompany\SafeCompany", inversedBy="policies")
     * @ORM\JoinColumn(name="safe_company_id", referencedColumnName="id")
     */
    private $safe_company;


    /**
     * @ORM\Column(length=10, nullable=true)
     */
    private $plate;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $chassis;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $policy_number;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $hash;

    /**
     * @ORM\Column(type="text")
     */
    private $observation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $policy_date;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $branch;

    /**
     * @ORM\Column(type="smallint", options={"default" : 1})
     */
    protected $status;

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * @param mixed $plate
     */
    public function setPlate($plate)
    {
        $this->plate = $plate;
    }

    /**
     * @return mixed
     */
    public function getChassis()
    {
        return $this->chassis;
    }

    /**
     * @param mixed $chassis
     */
    public function setChassis($chassis)
    {
        $this->chassis = $chassis;
    }

    /**
     * @return mixed
     */
    public function getPolicyNumber()
    {
        return $this->policy_number;
    }

    /**
     * @param mixed $policy_number
     */
    public function setPolicyNumber($policy_number)
    {
        $this->policy_number = $policy_number;
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
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @param mixed $observation
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
    }

    /**
     * @return mixed
     */
    public function getPolicyDate()
    {
        return $this->policy_date;
    }

    /**
     * @param mixed $policy_date
     */
    public function setPolicyDate($policy_date)
    {
        $this->policy_date = $policy_date;
    }

    /**
     * @return mixed
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param mixed $branch
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
    }

    /**
     * @return mixed
     */
    public function getSafeCompany()
    {
        return $this->safe_company;
    }

    /**
     * @param mixed $safe_company
     */
    public function setSafeCompany($safe_company): void
    {
        $this->safe_company = $safe_company;
    }



    public function __construct()
    {
        parent::__construct();
        $this->documents = new ArrayCollection();
        $this->insurance_claims = new ArrayCollection();
    }

    /**
     * @param $element
     */
    public function addDocuments($element)
    {
        $this->documents->add($element);
    }

    /**
     * @param $element
     */
    public function addClaims($element)
    {
        $this->insurance_claims->add($element);
    }

    /**
     * @return mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param mixed $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return Collection
     */
    public function getInsuranceClaims(): Collection
    {
        return $this->insurance_claims;
    }

    /**
     * @param Collection $insurance_claims
     */
    public function setInsuranceClaims(Collection $insurance_claims): void
    {
        $this->insurance_claims = $insurance_claims;
    }

    /**
     * @return Proposal
     */
    public function getProposal(): Proposal
    {
        return $this->proposal;
    }

    /**
     * @param Proposal $proposal
     */
    public function setProposal(Proposal $proposal): void
    {
        $this->proposal = $proposal;
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

    static public function showStatus($status): string
    {
        switch ($status) {
            case 0:
                return 'Deletado';
            case 1:
                return 'Ativo';
            default:
                return 'Inativo';
        }
    }
}
