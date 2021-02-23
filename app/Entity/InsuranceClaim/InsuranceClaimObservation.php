<?php

namespace App\Entity\InsuranceClaim;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InsuranceClaim\InsuranceClaimObservationRepository")
 * @ORM\Table(name="insurance_claims_observations")
 */
class InsuranceClaimObservation extends Entity
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InsuranceClaim\InsuranceClaim", inversedBy="observations")
     * @ORM\JoinColumn(name="insurance_claim_id", referencedColumnName="id")
     */
    private InsuranceClaim $insurance_claim;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}
