<?php


namespace App\Service\Claim\Core;


use App\Component\File;
use App\Component\Hash;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Entity\InsuranceClaim\InsuranceClaimThirdPartyDocument;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyDocumentRepository;
use Doctrine\ORM\EntityManager;

class RegisterClaimThirdDocument
{
    /**
     * @Inject
     * @var InsuranceClaimThirdPartyDocumentRepository
     */
    private InsuranceClaimThirdPartyDocumentRepository $claimThirdDocumentRepository;

    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @param $data
     * @param InsuranceClaimThirdParty $claim_third
     * @param $title
     * @return array
     * @throws \Exception
     */
    public function register($data, InsuranceClaimThirdParty $claim_third, $title): ?array
    {
        $claim_third_document = new InsuranceClaimThirdPartyDocument();

        $publicDir = dirname(__DIR__, 4) . '/public/upload/claim/';
        $targetPath = __DIR__ . '/../../../../public/upload/claim/' . $claim_third->getInsuranceClaim()->getHash() . '/third/' . $claim_third->getHash();
        if (!is_dir($targetPath) && !mkdir($concurrentDirectory = realpath($publicDir) . $claim_third->getInsuranceClaim()->getHash() . '/third/' . $claim_third->getHash(), 0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $claim_third_document->setDocument($title);
        $claim_third_document->setSize($data['size']);
        $claim_third_document->setHash(Hash::get($this->claimThirdDocumentRepository));

        $claim_third_document->setThirdParty($claim_third);
        $claim_third->addDocuments($claim_third_document);

        try {
            if (!$data['error']) {
                $f = File::up($targetPath, $data,
                    $claim_third_document->getHash());
                $claim_third_document->setFile($f->file_dst_name);
            }

            if (is_null($claim_third_document->getFile())) {
                throw new \RuntimeException('Ocorreu um erro ao enviar arquivo');
            }

            $this->entityManager->persist($claim_third);
            $this->entityManager->persist($claim_third_document);
            $this->entityManager->flush();

            return [
                'path' => '/upload/claim/' .$claim_third->getInsuranceClaim()->getHash() . '/third/' . $claim_third_document->getFile(),
                'document' => $claim_third_document
            ];

        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }

}