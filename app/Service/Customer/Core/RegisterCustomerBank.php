<?php


namespace App\Service\Customer\Core;


use App\Component\Hash;
use App\Entity\Customer\CustomerBank;
use App\Repository\Customer\CustomerBankRepository;
use Doctrine\ORM\EntityManager;

class RegisterCustomerBank
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @Inject
     * @var CustomerBankRepository
     */
    protected $customerBankRepository;

    public function register($data, $customer)
    {
        if (!empty($data)){
            foreach ($data as $key => $value) {
                if (!empty($value['observation']) || !empty($value['account'])
                    || !empty($value['agency']) || !empty($value['bank'])){
                    $customer_bank = $this->customerBankRepository->findOneBy(['hash' => $key]);

                    if (!is_object($customer_bank)){
                        $customer_bank = new CustomerBank();
                        $customer_bank->setHash(Hash::get($this->customerBankRepository));
                        $customer_bank->setCustomer($customer);
                    }

                    $customer_bank->setObservation($value['observation']);
                    $customer_bank->setAccount($value['account']);
                    $customer_bank->setAgency($value['agency']);
                    $customer_bank->setBank($value['bank']);

                    try {

                        $this->entityManager->persist($customer_bank);
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