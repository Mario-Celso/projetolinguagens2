<?php


namespace App\Service\Customer\Core;


use App\Component\File;
use App\Component\Hash;
use App\Controller\Controller;
use App\Entity\Customer\Customer;
use App\Repository\Customer\CustomerRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class RegisterCustomer
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var CustomerRepository
     */
    protected CustomerRepository $customerRepository;

    /**
     * @Inject
     * @var RegisterCustomerAddress
     */
    protected RegisterCustomerAddress $customer_address;

    /**
     * @Inject
     * @var RegisterCustomerCard
     */
    protected RegisterCustomerCard $customer_card;

    /**
     * @Inject
     * @var RegisterCustomerContact
     */
    protected RegisterCustomerContact $customer_contacts;

    /**
     * @Inject
     * @var RegisterCustomerBank
     */
    protected RegisterCustomerBank $customer_bank;

    /**
     * @Inject
     * @var RegisterCustomerDocument
     */
    protected RegisterCustomerDocument $registerCustomerDocument;


    /**
     * @param $data
     * @param $company
     * @return Customer
     * @throws \Exception
     */
    public function register($data, $company)
    {
        $customer = new Customer();

        $customer_document = $this->customerRepository->findOneBy(['document' => $data['document'], 'company' => $company->getId() ]);
        if (is_object($customer_document) && $customer_document->getId())
            throw new \Exception("Já existe um cliente com esse documento.");

        $customer->setHash(Hash::get($this->customerRepository));
        $customer->setStatus(Customer::STATUS_ACTIVE);
        $customer->setBirthday($this->convertDate($data['birthday']));
        $customer->setDocument($data['document']);
        $customer->setFirstName($data['first_name']);
        $customer->setLastName($data['last_name']);
        $customer->setCivilStatus($data['civil_status']);
        $customer->setProfession($data['profession']);
        $customer->setGender($data['gender']);
        $customer->setObservation($data['observation']);
        $customer->setDocumentRg($data['document_rg']);
        $customer->setDocumentRgOrigin($data['document_rg_origin']);
        $customer->setDocumentRgDate($this->convertDate($data['document_rg_date']));

        $customer->setEmissionCnhDate($this->convertDate($data['emission_cnh_date']));
        $customer->setDocumentCnh($data['document_cnh']);
        $customer->setCnhDueDate($this->convertDate($data['cnh_due_date']));
        $customer->setFirstCnhDate($this->convertDate($data['first_cnh_date']));


       $customer->setCompany($company);

        try {

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            $this->customer_address->register($data['address'], $customer);
            $this->customer_contacts->register($data['contacts'], $customer);
            $this->customer_bank->register($data['banks'], $customer);
            $this->customer_card->register($data['cards'],$customer);

            return $customer;

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function convertDate($data)
    {
        if ($data == null) {
            return null;
        } else {
            list($d, $m, $Y) = explode('/', $data);
            if (checkdate($m, $d, $Y)) {
                $d = new \Datetime($Y . '-' . $m . '-' . $d);
                return $d;
            }
        }
    }
}
