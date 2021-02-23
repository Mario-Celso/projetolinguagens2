<?php


namespace App\Service\Customer\Core;


use App\Component\Hash;
use App\Entity\Customer\CustomerContact;
use App\Repository\Customer\CustomerContactRepository;
use Doctrine\ORM\EntityManager;

class RegisterCustomerContact
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var CustomerContactRepository
     */
    protected CustomerContactRepository $customerContactRepository;

    /**
     * @param $data
     * @param $customer
     * @return bool
     * @throws \Exception
     */
    public function register($data, $customer)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (!empty($value['contact'])) {
                    $customer_contact = $this->customerContactRepository->findOneBy(['hash' => $key]);

                    if (!is_object($customer_contact)) {
                        $customer_contact = new CustomerContact();
                        $customer_contact->setHash(Hash::get($this->customerContactRepository));
                        $customer_contact->setCustomer($customer);
                    }

                    $customer_contact->setContact($value['contact']);
                    $customer_contact->setPreferential($value['preferential']);
                    $customer_contact->setType($value['type']);
                    $customer_contact->setBuildingType($value['building_type']);

                    try {

                        $this->entityManager->persist($customer_contact);
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