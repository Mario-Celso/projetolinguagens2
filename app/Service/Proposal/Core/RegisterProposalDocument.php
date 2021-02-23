<?php


namespace App\Service\Proposal\Core;


use App\Component\File;
use App\Component\Hash;
use App\Entity\Proposal\Proposal;
use App\Entity\Proposal\ProposalDocument;
use App\Repository\Proposal\ProposalDocumentRepository;
use Doctrine\ORM\EntityManager;

class RegisterProposalDocument
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var ProposalDocumentRepository
     */
    private ProposalDocumentRepository $proposalDocumentRepository;

    /**
     * @param $data
     * @param Proposal $proposal
     * @param $title
     * @return array
     * @throws \Exception
     */
    public function register($data, Proposal $proposal, $title): ?array
    {
        $proposal_document = new ProposalDocument();

        $publicDir = dirname(__DIR__, 4) . '/public/upload/proposal/';
        $targetPath = __DIR__ . '/../../../../public/upload/proposal/' . $proposal->getHash();
        if (!is_dir($targetPath) && !mkdir($concurrentDirectory = realpath($publicDir) . '/' . $proposal->getHash() . '/', 0777) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $proposal_document->setDocument($title);
        $proposal_document->setSize($data['size']);
        $proposal_document->setHash(Hash::get($this->proposalDocumentRepository));

        $proposal_document->setProposal($proposal);
        $proposal->addDocuments($proposal_document);

        try {
            if (!$data['error']) {
                $f = File::up($targetPath, $data,
                    $proposal_document->getHash());
                $proposal_document->setFile($f->file_dst_name);
            }

            if (is_null($proposal_document->getFile())) {
                throw new \RuntimeException('Ocorreu um erro ao enviar arquivo');
            }

            $this->entityManager->persist($proposal);
            $this->entityManager->persist($proposal_document);
            $this->entityManager->flush();

            return [
                'path' => '/upload/proposal/' . $proposal->getHash() . '/' . $proposal_document->getFile(),
                'document' => $proposal_document
            ];
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }

}