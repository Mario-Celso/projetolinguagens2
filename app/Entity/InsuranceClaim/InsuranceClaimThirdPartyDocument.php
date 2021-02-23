<?php


namespace App\Entity\InsuranceClaim;


use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceClaim\InsuranceClaimThirdPartyDocumentRepository")
 * @ORM\Table(name="insurance_claims_third_parties_documents")
 */
class InsuranceClaimThirdPartyDocument extends Entity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InsuranceClaim\InsuranceClaimThirdParty", inversedBy="documents")
     * @ORM\JoinColumn(name="third_party_id", referencedColumnName="id")
     */
    private InsuranceClaimThirdParty $third_party;

    /**
     * @ORM\Column(type="text", nullable=true)
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
     * @return InsuranceClaimThirdParty
     */
    public function getThirdParty(): InsuranceClaimThirdParty
    {
        return $this->third_party;
    }

    /**
     * @param InsuranceClaimThirdParty $third_party
     */
    public function setThirdParty(InsuranceClaimThirdParty $third_party): void
    {
        $this->third_party = $third_party;
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
