<?php

namespace App\Entity\Policy;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Policy\PolicyDocumentRepository")
 * @ORM\Table(name="policies_documents")
 */
class PolicyDocument extends Entity
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Policy\Policy", inversedBy="documents")
     * @ORM\JoinColumn(name="policy_id", referencedColumnName="id")
     */
    private $policies;

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
    public function getPolicies()
    {
        return $this->policies;
    }

    /**
     * @param mixed $policies
     */
    public function setPolicies($policies)
    {
        $this->policies = $policies;
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
    public function setDocument($document)
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
    public function setHash($hash)
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
