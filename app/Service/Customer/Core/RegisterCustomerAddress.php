<?php


namespace App\Service\Customer\Core;


use App\Component\Hash;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerAddress;
use App\Repository\Customer\CustomerAddressRepository;
use Doctrine\ORM\EntityManager;

class RegisterCustomerAddress
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var CustomerAddressRepository
     */
    protected CustomerAddressRepository $customerAddressRepository;

    /**
     * @param $data
     * @param $customer
     * @return bool
     * @throws \Exception
     */
    public function register($data, Customer $customer)
    {
        if (!empty($data)){
            foreach ($data as $key => $value) {

                if (!empty($value['complement']) ||
                    !empty($value['district']) ||
                    !empty($value['address']) ||
                    !empty($value['number']) ||
                    !empty($value['state']) ||
                    !empty($value['city']) ||
                    !empty($value['zip'])) {

                    $customer_address = $this->customerAddressRepository->findOneBy(['hash' => $key]);


                    if (!is_object($customer_address)){
                        $customer_address = new CustomerAddress();
                        $customer_address->setHash(Hash::get($this->customerAddressRepository));

                        $customer_address->setCustomer($customer);
                        $customer->addAddress($customer_address);
                    }

                    $customer_address->setAddressType($value['address_type']);
                    $customer_address->setPreferential($value['preferential']);
                    $customer_address->setComplement($value['complement']);
                    $customer_address->setDistrict($value['district']);
                    $customer_address->setAddress($value['address']);
                    $customer_address->setNumber($value['number']);
                    $customer_address->setState($value['state']);
                    $customer_address->setCity($value['city']);
                    $customer_address->setZip($value['zip']);

                    try {

                        $this->entityManager->persist($customer_address);
                        $this->entityManager->persist($customer);
                        $this->entityManager->flush();

                    } catch (\Exception $exception) {
                        throw new \Exception($exception->getMessage());

                    }
                }
            }

            return true;
        }
    }
}