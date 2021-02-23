<?php


namespace App\Entity\SafeCompany;


use App\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SafeCompany\SafeCompanyRepository")
 * @ORM\Table(name="safe_companies")
 */

class SafeCompany extends Entity
{

    public const SAFE_COMPANY_STATUS_ACTIVE = 1;
    public const SAFE_COMPANY_STATUS_INACTIVE = 0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Company\Company",inversedBy="safe_companies")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\OnetoMany(targetEntity="App\Entity\Proposal\Proposal", mappedBy="safe_company")
     */
    protected Collection $proposals;

    /**
     * @ORM\OnetoMany(targetEntity="App\Entity\Policy\Policy", mappedBy="safe_company")
     */
    protected Collection $policy;

    /**
     * @ORM\Column(length=200)
     */
    protected $insurer;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * @ORM\Column(length=200)
     */
    protected $hash;

    public function __construct()
    {
        parent::__construct();
        $this->proposals = new ArrayCollection();
        $this->policy = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getInsurer()
    {
        return $this->insurer;
    }

    /**
     * @param mixed $insurer
     */
    public function setInsurer($insurer): void
    {
        $this->insurer = $insurer;
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