<?php


namespace App\Service\Customer\Core;


use App\Component\Hash;
use App\Entity\Customer\CustomerCard;
use App\Repository\Customer\CustomerCardRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use Exception;

class RegisterCustomerCard
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var CustomerCardRepository
     */
    protected CustomerCardRepository $customerCardRepository;


    /**
     * @param $data
     * @param $customer
     * @return bool
     * @throws Exception
     */

    public function register($data, $customer)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {

                if (!empty($value['number']) || !empty($value['due_date']) || !empty($value['title_name'])) {

                    $card = $this->customerCardRepository->findOneBy(['hash' => $key]);

                    if (!is_object($card)) {
                        $card = new CustomerCard();
                        $card->setHash(Hash::get($this->customerCardRepository));
                        $card->setCustomer($customer);
                        $customer->addCards($card);
                    }
                    $card->setNumber($value['number']);
                    $card->setDueDate($this->convertDate($value['due_date']));
                    $card->setTitleName($value['title_name']);
                    $card->setObservation($value['observation']);

                    try {
                        $this->entityManager->persist($card);
                        $this->entityManager->persist($customer);
                        $this->entityManager->flush();

                    } catch (Exception $exception) {
                        throw new Exception($exception->getMessage());
                    }
                }

            }
            return null;
        }

    }

    public function convertDate($data)
    {
        if ($data == null) {
            return null;
        } else {
            list($m, $Y) = explode('/', $data);
            $d = 01;
            if (checkdate($m, $d, $Y)) {
                $d = new \Datetime($Y . '-' . $m . '-' . $d);
                return $d;
            }
        }


    }
}