<?php


namespace App\Service\Customer\Core;


use App\Component\File;
use App\Component\Hash;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerDocuments;
use App\Repository\Customer\CustomerDocumentsRepository;
use Doctrine\ORM\EntityManager;
use function PHPUnit\Framework\isNan;

class RegisterCustomerDocument
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var CustomerDocumentsRepository
     */
    private CustomerDocumentsRepository $customerDocumentsRepository;

    /**
     * @param $data
     * @param Customer $customer
     * @param $title
     * @return array
     * @throws \Exception
     */
    public function register($data, Customer $customer, $title): ?array
    {
        $customer_document = new CustomerDocuments();
        $publicDir = dirname(__DIR__, 4) . '/public/upload/customer/';
        $targetPath = __DIR__ . '/../../../../public/upload/customer/' . $customer->getHash();
        if (!is_dir($targetPath) && !mkdir($concurrentDirectory = realpath($publicDir) . '/' . $customer->getHash() . '/', 0777) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $customer_document->setDocument($title);
        $customer_document->setSize($data['size']);
        $customer_document->setHash(Hash::get($this->customerDocumentsRepository));

        $customer_document->setCustomer($customer);
        $customer->addDocuments($customer_document);

        try {
            if (!$data['error']) {
                $f = File::up($targetPath, $data,
                    $customer_document->getHash());
                $customer_document->setFile($f->file_dst_name);
            }

            if (is_null($customer_document->getFile())) {
                throw new \RuntimeException('Ocorreu um erro ao enviar arquivo');
            }

            $this->entityManager->persist($customer);
            $this->entityManager->persist($customer_document);
            $this->entityManager->flush();

            return [
                'path' => '/upload/customer/' . $customer->getHash() . '/' . $customer_document->getFile(),
                'document' => $customer_document
            ];

        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }

}