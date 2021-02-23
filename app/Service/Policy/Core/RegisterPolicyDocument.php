<?php


namespace App\Service\Policy\Core;


use App\Component\File;
use App\Component\Hash;
use App\Entity\Policy\Policy;
use App\Entity\Policy\PolicyDocument;
use App\Repository\Policy\PolicyDocumentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class RegisterPolicyDocument
{
    /**
     * @Inject
     * @var PolicyDocumentRepository
     */
    private PolicyDocumentRepository $policyDocumentRepository;

    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @param $data
     * @param Policy $policy
     * @param $title
     * @return array|null
     * @throws \Exception
     */
    public function register($data, Policy $policy, $title): ?array
    {
        $policy_document = new PolicyDocument();

        $publicDir = dirname(__DIR__, 4) . '/public/upload/policy/';
        $targetPath = __DIR__ . '/../../../../public/upload/policy/' . $policy->getHash();
        if (!is_dir($targetPath) && !mkdir($concurrentDirectory = realpath($publicDir) . '/' . $policy->getHash() . '/', 0777) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $policy_document->setDocument($title);
        $policy_document->setSize($data['size']);
        $policy_document->setHash(Hash::get($this->policyDocumentRepository));

        $policy_document->setPolicies($policy);
        $policy->addDocuments($policy_document);


        try {
            if (!$data['error']) {
                $f = File::up($targetPath, $data,
                    $policy_document->getHash());
                $policy_document->setFile($f->file_dst_name);
            }

            if (is_null($policy_document->getFile())) {
                throw new \RuntimeException('Ocorreu um erro ao enviar arquivo');
            }

            $this->entityManager->persist($policy);
            $this->entityManager->persist($policy_document);
            $this->entityManager->flush();

            return [
                'path' => '/upload/policy/' . $policy->getHash() . '/' . $policy_document->getFile(),
                'document' => $policy_document
            ];
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

}