<?php


namespace App\Service\Claim;


use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyDocumentRepository;
use App\Service\Service;
use Doctrine\ORM\ORMException;

class ClaimThirdDocumentService extends Service
{

    /**
     * @Inject
     * @var InsuranceClaimThirdPartyDocumentRepository
     */
    protected $entityRepository;

    /**
     * @param $data
     * @return mixed
     * @throws ORMException
     */


    /*public function updateDocument($data)
    {
        if (isset($data['title_third'])) {
            foreach ($data['title_third'] as $key => $title) {
                if ($key === '{document_id}') {
                    continue;
                }
                $key = substr($key, 1, -1);
                $document = $this->entityRepository->find($key);
                if (!is_null($document)) {
                    $document->setDocument($title);
                    $this->entityManager->persist($document);
                }
            }
        }
        return $data;
    }*/

}