<?php

namespace App\Entity\Proposal;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Proposal\ProposalDocumentRepository")
 * @ORM\Table(name="proposals_documents")
 */
class ProposalDocument extends Entity
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proposal\Proposal", inversedBy="documents")
     * @ORM\JoinColumn(name="proposal_id", referencedColumnName="id")
     */
    private $proposal;

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
    public function getProposal(): Proposal
    {
        return $this->proposal;
    }

    /**
     * @param mixed $proposal
     */
    public function setProposal($proposal): void
    {
        $this->proposal = $proposal;
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
