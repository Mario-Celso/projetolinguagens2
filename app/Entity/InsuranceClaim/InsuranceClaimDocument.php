<?php

namespace App\Entity\InsuranceClaim;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceClaim\InsuranceClaimDocumentRepository")
 * @ORM\Table(name="insurance_claims_documents")
 */
class InsuranceClaimDocument extends Entity
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InsuranceClaim\InsuranceClaim", inversedBy="documents")
     * @ORM\JoinColumn(name="insurance_claim_id", referencedColumnName="id")
     */
    private $insurance_claim;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $document;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $file;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $hash;

    /**
     * @return mixed
     */
    public function getInsuranceClaim(): InsuranceClaim
    {
        return $this->insurance_claim;
    }

    /**
     * @param mixed $insurance_claim
     */
    public function setInsuranceClaim($insurance_claim): void
    {
        $this->insurance_claim = $insurance_claim;
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
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }



}
