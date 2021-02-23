<?php

namespace App\Entity\Customer;

use App\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Customer\CustomerRepository")
 * @ORM\Table(name="customers")
 */
class Customer extends Entity
{
    const CIVIL_STATE_SOLTEIRO = 1;
    const CIVIL_STATE_CASADO = 2;
    const CIVIL_STATE_SEPARADO = 3;
    const CIVIL_STATE_DIVORCIADO = 4;
    const CIVIL_STATE_VIUVO = 5;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Company\Company",inversedBy="customers")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\Customer\CustomerCard", mappedBy="customer")
     */
    private Collection $cards;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\Customer\CustomerAddress", mappedBy="customer")
     */
    private Collection $address;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\Proposal\Proposal", mappedBy="customer")
     */
    private Collection $proposals;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\InsuranceClaim\InsuranceClaim", mappedBy="customer")
     */
    private Collection $insurance_claims;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\Policy\Policy", mappedBy="customer")
     */
    private Collection $policies;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\Customer\CustomerBank", mappedBy="customer")
     */
    private Collection $banks;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\Customer\CustomerContact", mappedBy="customer")
     */
    private Collection $contacts;

    /**
     * @ORM\OnetoMany(targetEntity="\App\Entity\Customer\CustomerDocuments", mappedBy="customer")
     */
    private Collection $customer_document;

    /**
     * @ORM\Column(length=100)
     */
    protected $first_name;

    /**
     * @ORM\Column(length=100)
     */
    protected $last_name;

    /**
     * @ORM\Column(type="smallint", options={"default" : 1})
     */
    protected $status;

    /**
     * @ORM\Column(length=100)
     */
    protected $document;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthday;

    /**
     * @ORM\Column(length=2 ,type="string")
     */
    protected $gender;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $civil_status;

    /**
     * @ORM\Column(type="date")
     */
    protected $first_cnh_date;

    /**
     * @ORM\Column(type="date")
     */
    protected $emission_cnh_date;

    /**
     * @ORM\Column(length=60)
     */
    protected $document_cnh;

    /**
     * @ORM\Column(type="date")
     */
    protected $cnh_due_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $observation;

    /**
     * @ORM\Column(type="text")
     */
    protected $profession;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    protected $document_rg;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $document_rg_origin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $document_rg_date;

    /**
     * @ORM\Column(length=60)
     */
    protected $hash;

    public function __construct()
    {
        parent::__construct();
        $this->cards = new ArrayCollection();
        $this->address = new ArrayCollection();
        $this->proposals = new ArrayCollection();
        $this->insurance_claims = new ArrayCollection();
        $this->policies = new ArrayCollection();
        $this->banks = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->customer_document = new ArrayCollection();
    }

    public function addDocuments($element)
    {
        $this->customer_document->add($element);
    }

    public function addAddress($element)
    {
        $this->address->add($element);
    }

    public function addClaim($element)
    {
        $this->insurance_claims->add($element);
    }

    public function addPolicy($element)
    {
        $this->policies->add($element);
    }

    public function addBank($element)
    {
        $this->banks->add($element);
    }

    public function addContact($element)
    {
        $this->contacts->add($element);
    }

    public function addCards($element)
    {
        $this->cards->add($element);
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return Collection
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    /**
     * @param Collection $proposals
     */
    public function setProposals(Collection $proposals): void
    {
        $this->proposals = $proposals;
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
     * @return mixed
     */
    public function getPolicies()
    {
        return $this->policies;
    }

    /**
     * @param mixed $policies
     */
    public function setPolicies($policies): void
    {
        $this->policies = $policies;
    }

    /**
     * @return mixed
     */
    public function getBanks()
    {
        return $this->banks;
    }

    /**
     * @param mixed $banks
     */
    public function setBanks($banks): void
    {
        $this->banks = $banks;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts): void
    {
        $this->contacts = $contacts;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
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
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getCivilStatus()
    {
        return $this->civil_status;
    }

    /**
     * @param mixed $civil_status
     */
    public function setCivilStatus($civil_status): void
    {
        $this->civil_status = $civil_status;
    }

    /**
     * @return mixed
     */
    public function getFirstCnhDate()
    {
        return $this->first_cnh_date;
    }

    /**
     * @param mixed $first_cnh_date
     */
    public function setFirstCnhDate($first_cnh_date): void
    {
        $this->first_cnh_date = $first_cnh_date;
    }

    /**
     * @return mixed
     */
    public function getEmissionCnhDate()
    {
        return $this->emission_cnh_date;
    }

    /**
     * @param mixed $emission_cnh_date
     */
    public function setEmissionCnhDate($emission_cnh_date): void
    {
        $this->emission_cnh_date = $emission_cnh_date;
    }

    /**
     * @return mixed
     */
    public function getDocumentCnh()
    {
        return $this->document_cnh;
    }

    /**
     * @param mixed $document_cnh
     */
    public function setDocumentCnh($document_cnh): void
    {
        $this->document_cnh = $document_cnh;
    }

    /**
     * @return mixed
     */
    public function getCnhDueDate()
    {
        return $this->cnh_due_date;
    }

    /**
     * @param mixed $cnh_due_date
     */
    public function setCnhDueDate($cnh_due_date): void
    {
        $this->cnh_due_date = $cnh_due_date;
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
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param mixed $profession
     */
    public function setProfession($profession): void
    {
        $this->profession = $profession;
    }

    /**
     * @return mixed
     */
    public function getDocumentRg()
    {
        return $this->document_rg;
    }

    /**
     * @param mixed $document_rg
     */
    public function setDocumentRg($document_rg): void
    {
        $this->document_rg = $document_rg;
    }

    /**
     * @return mixed
     */
    public function getDocumentRgOrigin()
    {
        return $this->document_rg_origin;
    }

    /**
     * @param mixed $document_rg_origin
     */
    public function setDocumentRgOrigin($document_rg_origin): void
    {
        $this->document_rg_origin = $document_rg_origin;
    }

    /**
     * @return mixed
     */
    public function getDocumentRgDate()
    {
        return $this->document_rg_date;
    }

    /**
     * @param mixed $document_rg_date
     */
    public function setDocumentRgDate($document_rg_date): void
    {
        $this->document_rg_date = $document_rg_date;
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
     * @return Collection
     */
    public function getCustomerDocument(): Collection
    {
        return $this->customer_document;
    }

    /**
     * @param Collection $customer_document
     */
    public function setCustomerDocument(Collection $customer_document): void
    {
        $this->customer_document = $customer_document;
    }

    public function addProposal($element)
    {
        $this->proposals->add($element);
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
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param mixed $cards
     */
    public function setCards($cards): void
    {
        $this->cards = $cards;
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
