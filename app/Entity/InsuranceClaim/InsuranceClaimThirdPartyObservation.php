<?php


namespace App\Entity\InsuranceClaim;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceClaim\InsuranceClaimThirdPartyObservationRepository")
 * @ORM\Table(name="insurance_claims_third_parties_observations")
 */
class InsuranceClaimThirdPartyObservation extends Entity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InsuranceClaim\InsuranceClaimThirdParty", inversedBy="documents")
     * @ORM\JoinColumn(name="third_party_id", referencedColumnName="id")
     */
    private InsuranceClaimThirdParty $third_party;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $hash;

    /**
     * @ORM\Column(length=60, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observation;

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

}