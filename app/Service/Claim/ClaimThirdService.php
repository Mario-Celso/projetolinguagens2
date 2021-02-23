<?php


namespace App\Service\Claim;


use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository;
use App\Service\Service;

/**
 * Class ClaimThirdService
 * @method InsuranceClaimThirdParty|false hash($hash)
 * @package App\Service\Claim
 */
class ClaimThirdService extends Service
{
    /**
     * @Inject
     * @var InsuranceClaimThirdPartyRepository
     */
    public $entityRepository;

}