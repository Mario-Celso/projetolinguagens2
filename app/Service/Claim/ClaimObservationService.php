<?php


namespace App\Service\Claim;


use App\Repository\InsuranceClaim\InsuranceClaimObservationRepository;
use App\Service\Service;

class ClaimObservationService extends Service
{
    /**
     * @Inject
     * @var InsuranceClaimObservationRepository
     */
    public $entityRepository;

}