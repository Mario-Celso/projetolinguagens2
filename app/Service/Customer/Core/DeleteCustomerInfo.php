<?php


namespace App\Service\Customer\Core;


use App\Repository\Customer\CustomerAddressRepository;
use App\Repository\Customer\CustomerBankRepository;
use App\Repository\Customer\CustomerCardRepository;
use App\Repository\Customer\CustomerContactRepository;
use App\Repository\Customer\CustomerDocumentsRepository;
use App\Repository\InsuranceClaim\InsuranceClaimDocumentRepository;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyDocumentRepository;
use App\Repository\Policy\PolicyDocumentRepository;
use App\Repository\Proposal\ProposalDocumentRepository;
use Doctrine\ORM\EntityManager;

class DeleteCustomerInfo
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var CustomerBankRepository
     */
    protected CustomerBankRepository $bankRepository;

    /**
     * @Inject
     * @var CustomerAddressRepository
     */
    protected CustomerAddressRepository $addressRepository;

    /**
     * @Inject
     * @var CustomerContactRepository
     */
    protected CustomerContactRepository $contactRepository;

    /**
     * @Inject
     * @var CustomerCardRepository
     */
    protected CustomerCardRepository $cardRepository;

    /**
     * @Inject
     * @var CustomerDocumentsRepository
     */
    protected CustomerDocumentsRepository $documentsRepository;

    /**
     * @Inject
     * @var ProposalDocumentRepository
     */
    protected ProposalDocumentRepository $proposalDocumentsRepository;

    /**
     * @Inject
     * @var InsuranceClaimDocumentRepository
     */
    protected InsuranceClaimDocumentRepository $insuranceDocumentsRepository;

    /**
     * @Inject
     * @var InsuranceClaimThirdPartyDocumentRepository
     */
    protected InsuranceClaimThirdPartyDocumentRepository  $insuranceThirdDocumentsRepository;

    /**
     * @Inject
     * @var PolicyDocumentRepository
     */
    protected PolicyDocumentRepository  $policyDocumentsRepository;

    public function deleteInfo($data_hash, $info_type = null, $type = null)
    {
        switch ($info_type) {
            case 'bank':
                $bank = $this->bankRepository->findOneBy(['hash' => $data_hash]);
                $bank->setDeletedAt(new \DateTime());
                $this->entityManager->persist($bank);
                $this->entityManager->flush();
                return $bank;
                break;
            case 'address':
                $address = $this->addressRepository->findOneBy(['hash' => $data_hash]);
                $address->setDeletedAt(new \DateTime());
                $this->entityManager->persist($address);
                $this->entityManager->flush();
                return $address;
                break;
            case 'contact':
                $contact = $this->contactRepository->findOneBy(['hash' => $data_hash]);
                $contact->setDeletedAt(new \DateTime());
                $this->entityManager->persist($contact);
                $this->entityManager->flush();
                return $contact;
                break;

            case 'card':
                $card = $this->cardRepository->findOneBy(['hash'=> $data_hash]);
                $card->setDeletedAt(new \DateTime());
                $this->entityManager->persist($card);
                $this->entityManager->flush();
                return $card;
                break;

            case 'doc':
                $doc = $this->typeDelete($type, $data_hash);
                $doc->setDeletedAt(new \DateTime());
                $this->entityManager->persist($doc);
                $this->entityManager->flush();
                return $doc;

        }
    }

    public function typeDelete($type, $id)
    {
        switch ($type) {
            case 'customer':
                $doc = $this->documentsRepository->findOneBy(['id'=> $id]);
                return $doc;
                break;

            case 'proposal':
                $doc = $this->proposalDocumentsRepository->findOneBy(['id'=> $id]);
                return $doc;
                break;

            case 'insurance':
                $doc = $this->insuranceDocumentsRepository->findOneBy(['id'=> $id]);
                return $doc;
                break;

            case 'policy':
                $doc = $this->policyDocumentsRepository->findOneBy(['id'=> $id]);
                return $doc;
                break;

             case 'insurance_third':
                $doc = $this->insuranceThirdDocumentsRepository->findOneBy(['id'=> $id]);
                return $doc;
                break;

        }
    }
}