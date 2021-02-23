<?php


namespace App\Entity\InsuranceClaim;

use App\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository")
 * @ORM\Table(name="insurance_claims_third_parties")
 */
class InsuranceClaimThirdParty extends Entity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InsuranceClaim\InsuranceClaim", inversedBy="third_party")
     * @ORM\JoinColumn(name="insurance_claim_id", referencedColumnName="id")
     */
    private InsuranceClaim $insurance_claim;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InsuranceClaim\InsuranceClaimThirdPartyDocument", mappedBy="third_party")
     */
    private Collection $documents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InsuranceClaim\InsuranceClaimThirdPartyObservation", mappedBy="third_party")
     */
    private Collection $observations;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(length=100)
     */
    protected $document_identifier;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $hash;

    public function __construct()
    {
        parent::__construct();
        $this->documents = new ArrayCollection();
        $this->observations = new ArrayCollection();
    }

    public function addDocuments($element)
    {
        $this->documents->add($element);
    }

    public function addObservations(InsuranceClaimThirdPartyObservation $element): void
    {
        if (!$this->observations->contains($element)) {
            $this->observations->add($element);
            $element->setThirdParty($this);
        }
    }

    /**
     * @return InsuranceClaim
     */
    public function getInsuranceClaim(): InsuranceClaim
    {
        return $this->insurance_claim;
    }

    /**
     * @param InsuranceClaim $insurance_claim
     */
    public function setInsuranceClaim(InsuranceClaim $insurance_claim): void
    {
        $this->insurance_claim = $insurance_claim;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param ArrayCollection|Collection $documents
     */
    public function setDocuments($documents): void
    {
        $this->documents = $documents;
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
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param mixed $observation
     */
    public function setObservation($observation): void
    {
        $this->observations = $observation;
    }

    /**
     * @return mixed
     */
    public function getDocumentIdentifier()
    {
        return $this->document_identifier;
    }

    /**
     * @param mixed $document_identifier
     */
    public function setDocumentIdentifier($document_identifier): void
    {
        $this->document_identifier = $document_identifier;
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





}