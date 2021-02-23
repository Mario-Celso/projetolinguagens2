<?php

namespace App\Entity\Customer;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Customer\CustomerContactRepository")
 * @ORM\Table(name="customers_contacts")
 */
class CustomerContact extends Entity
{
    const CONTACT_TYPE_EMAIL = 1;
    const CONTACT_TYPE_PHONE = 2;
    const CONTACT_TYPE_CELLPHONE = 3;
    const CONTACT_TYPE_WHATSAPP = 4;
    const CONTACT_TYPE_FAX = 5;

    const CONTACT_WHERE_HOME = 1;
    const CONTACT_WHERE_COMMERCIAL = 2;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="contacts")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\Column(length=150, nullable=true)
     */
    protected $contact;

    /**
     * @ORM\Column(type="smallint", nullable=true )
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $preferential;

    /**
     * @ORM\Column(type="smallint", nullable=true )
     */
    protected $building_type;

    /**
     * @ORM\Column(length=60)
     */
    protected $hash;

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getBuildingType()
    {
        return $this->building_type;
    }

    /**
     * @param mixed $building_type
     */
    public function setBuildingType($building_type): void
    {
        $this->building_type = $building_type;
    }

    /**
     * @return mixed
     */
    public function getPreferential()
    {
        return $this->preferential;
    }

    /**
     * @param mixed $preferential
     */
    public function setPreferential($preferential): void
    {
        $this->preferential = $preferential;
    }
}
