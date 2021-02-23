<?php

namespace App\Entity\InsuranceClaim;

use App\Entity\Customer\Customer;
use App\Entity\Entity;
use App\Entity\Policy\Policy;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceClaim\InsuranceClaimRepository")
 * @ORM\Table(name="insurance_claims")
 */
class InsuranceClaim extends Entity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Company",inversedBy="insurance_claim")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InsuranceClaim\InsuranceClaimDocument", mappedBy="insurance_claim", cascade={"persist"})
     */
    private Collection $documents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InsuranceClaim\InsuranceClaimObservation", mappedBy="insurance_claim")
     */
    private Collection $observations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InsuranceClaim\InsuranceClaimThirdParty", mappedBy="insurance_claim")
     */
    private Collection $third_party;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Policy\Policy", inversedBy="insurance_claims")
     * @ORM\JoinColumn(name="policy_id", referencedColumnName="id")
     */
    private Policy $policy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer", inversedBy="insurance_claims")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private Customer $customer;

    /**
     * @ORM\Column(length=60)
     */
    private $hash;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $status;

    public function __construct()
    {
        parent::__construct();
        $this->third_party = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->observations = new ArrayCollection();
    }

    public function addDocuments($element)
    {
        $this->documents->add($element);
    }

    public function addThirdParty($element)
    {
        $this->third_party->add($element);
    }

    public function addObservations($element)
    {
        $this->observations->add($element);
    }

    /**
     * @param mixed $documents
     */
    public function setDocuments($documents): void
    {
        $this->documents = $documents;
    }

    /**
     * @return mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
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
     * @return ArrayCollection|Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param ArrayCollection|Collection $observation
     */
    public function setObservations($observation): void
    {
        $this->observations = $observation;
    }

    /**
     * @return Policy
     */
    public function getPolicy(): Policy
    {
        return $this->policy;
    }

    /**
     * @param mixed $policy
     */
    public function setPolicy($policy): void
    {
        $this->policy = $policy;
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
    public function setStatus($status)
    {
        $this->status = $status;
    }

    static public function showStatus($status): string
    {
        switch ($status) {
            case 0:
                return 'Aberta/Em andamento';
            case 1:
                return 'Finalizada';
            case 2:
                return 'Cancelada';
            case 3:
                return 'Deletada';
            default:
                return 'Invalido';
        }
    }

    /**
     * @return Collection
     */
    public function getThirdParty(): Collection
    {
        return $this->third_party;
    }

    /**
     * @param Collection $third_party
     */
    public function setThirdParty(Collection $third_party): void
    {
        $this->third_party = $third_party;
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



}
