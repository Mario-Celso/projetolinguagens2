<?php

namespace App\Entity\Customer;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Customer\CustomerAddressRepository")
 * @ORM\Table(name="customers_address")
 */
class CustomerAddress extends Entity
{

    const ADDRESS_HOME = 1;
    const ADDRESS_COMMERCIAL = 2;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="address")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    protected $zip;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $number;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $complement;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $district;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(length=60)
     */
    protected $hash;

    /**
     * @ORM\Column(type="smallint", nullable=true )
     */
    protected $address_type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $preferential;

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
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
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
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param mixed $complement
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param mixed $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getAddressType()
    {
        return $this->address_type;
    }

    /**
     * @param mixed $address_type
     */
    public function setAddressType($address_type)
    {
        $this->address_type = $address_type;
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
