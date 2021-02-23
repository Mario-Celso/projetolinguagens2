<?php


namespace App\Service\Claim\Core;

use App\Component\File;
use App\Component\Hash;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimDocument;
use App\Repository\InsuranceClaim\InsuranceClaimDocumentRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class RegisterClaimDocument
 * @package App\Service\Claim\Core
 */
class RegisterClaimDocument
{

    /**
     * @Inject
     * @var InsuranceClaimDocumentRepository
     */
    private InsuranceClaimDocumentRepository $claimDocumentRepository;

    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @param $data
     * @param InsuranceClaim $claim
     * @param $title
     * @return array
     * @throws \Exception
     */
    public function register($data, InsuranceClaim $claim, $title): ?array
    {
        $claim_document = new InsuranceClaimDocument();

        $publicDir = dirname(__DIR__, 4) . '/public/upload/claim/';
        $targetPath = __DIR__ . '/../../../../public/upload/claim/' . $claim->getHash();
        if (!is_dir($targetPath) && !mkdir($concurrentDirectory = realpath($publicDir) . '/' . $claim->getHash() . '/', 0777) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $claim_document->setDocument($title);
        $claim_document->setSize($data['size']);
        $claim_document->setHash(Hash::get($this->claimDocumentRepository));

        $claim_document->setInsuranceClaim($claim);
        $claim->addDocuments($claim_document);

        try {
            if (!$data['error']) {
                $f = File::up($targetPath, $data,
                    $claim_document->getHash());
                $claim_document->setFile($f->file_dst_name);
            }

            if (is_null($claim_document->getFile())) {
                throw new \RuntimeException('Ocorreu um erro ao enviar arquivo');
            }

            $this->entityManager->persist($claim);
            $this->entityManager->persist($claim_document);
            $this->entityManager->flush();

            return [
                'path' => '/upload/claim/' . $claim->getHash() . '/' . $claim_document->getFile(),
                'document' => $claim_document
            ];

        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }

}