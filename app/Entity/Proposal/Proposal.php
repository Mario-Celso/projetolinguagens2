<?php

namespace App\Entity\Proposal;

use App\Entity\Customer\Customer;
use App\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Proposal\ProposalRepository")
 * @ORM\Table(name="proposals")
 */
class Proposal extends Entity
{

    const STATE_NEW_VEHICLE = 0;
    const STATE_USED_VEHICLE = 1;

    const PROPOSAL_STATUS_CREATED = 0;
    const PROPOSAL_STATUS_SENT = 1;
    const PROPOSAL_STATUS_APPROVED = 2;
    const PROPOSAL_STATUS_DISAPPROVED = 3;
    const PROPOSAL_STATUS_DELETED= 4;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Company",inversedBy="proposal")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposal\ProposalDocument", mappedBy="proposal", cascade={"persist"})
     */
    private Collection $documents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Policy\Policy", mappedBy="proposal")
     */
    private Collection $policies;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer", inversedBy="proposals")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\SafeCompany\SafeCompany", inversedBy="proposals")
     * @ORM\JoinColumn(name="safe_company_id", referencedColumnName="id")
     */
    private $safe_company;

    /**
     * @ORM\Column(length=12, nullable=true)
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
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $vehicle_state;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $due_date_start;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $due_date_end;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $status;

    public function __construct()
    {
        parent::__construct();
        $this->documents = new ArrayCollection();
        $this->policies = new ArrayCollection();
    }

    public function addDocuments($element)
    {
        $this->documents->add($element);
    }

    /**
     * @param mixed $documents
     */
    public function setdocuments($documents): void
    {
        $this->documents = $documents;
    }

    /**
     * @return Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return mixed
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
    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * @param mixed $plate
     */
    public function setPlate($plate): void
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
    public function setChassis($chassis): void
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
    public function setPolicyNumber($policy_number): void
    {
        $this->policy_number = $policy_number;
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
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @param mixed $observation
     */
    public function setObservation($observation): void
    {
        $this->observation = $observation;
    }

    /**
     * @return mixed
     */
    public function getVehicleState()
    {
        return $this->vehicle_state;
    }

    /**
     * @param mixed $vehicle_state
     */
    public function setVehicleState($vehicle_state): void
    {
        $this->vehicle_state = $vehicle_state;
    }

    /**
     * @return mixed
     */
    public function getDueDateStart()
    {
        return $this->due_date_start;
    }

    /**
     * @param mixed $due_date_start
     * @throws \Exception
     */
    public function setDueDateStart($due_date_start): void
    {
        if ($due_date_start == null || empty($due_date_start)) {
            $this->due_date_start = null;
        } else {
            list($d, $m, $Y) = explode('/', $due_date_start);
            if (checkdate($m, $d, $Y)) {
                $d = new \Datetime($Y . '-' . $m . '-' . $d);
                $this->due_date_start = $d;
            }
        }
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
    public function getPolicies(): Collection
    {
        return $this->policies;
    }

    /**
     * @param Collection $policies
     */
    public function setPolicies(Collection $policies): void
    {
        $this->policies = $policies;
    }

    /**
     * @param $element
     */
    public function addPolicies($element)
    {
        $this->policies->add($element);
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
    public function getDueDateEnd()
    {
        return $this->due_date_end;
    }

    /**
     * @param mixed $due_date_end
     * @throws \Exception
     */
    public function setDueDateEnd($due_date_end): void
    {
        if ($due_date_end == null || empty($due_date_end)) {
            $this->due_date_end = null;
        } else {
            list($d, $m, $Y) = explode('/', $due_date_end);
            if (checkdate($m, $d, $Y)) {
                $d = new \Datetime($Y . '-' . $m . '-' . $d);
                $this->due_date_end = $d;
            }
        }
    }


}
