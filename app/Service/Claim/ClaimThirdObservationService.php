<?php


namespace App\Service\Claim;


use App\Entity\InsuranceClaim\InsuranceClaimThirdPartyObservation;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyObservationRepository;
use App\Service\Service;

/**
 * Class ClaimThirdObservationService
 * @method InsuranceClaimThirdPartyObservation|false hash($hash)
 * @package App\Service\Claim
 */
class ClaimThirdObservationService extends Service
{
    /**
     * @Inject
     * @var InsuranceClaimThirdPartyObservationRepository
     */
    protected $entityRepository;
}