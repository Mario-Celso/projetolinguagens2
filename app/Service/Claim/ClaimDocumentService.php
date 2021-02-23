<?php


namespace App\Service\Claim;


use App\Repository\InsuranceClaim\InsuranceClaimDocumentRepository;
use App\Service\Service;

class ClaimDocumentService extends Service
{

    /**
     * @Inject
     * @var InsuranceClaimDocumentRepository
     */
    protected $entityRepository;

}