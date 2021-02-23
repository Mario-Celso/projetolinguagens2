<?php

namespace App\Service\Claim;

use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Repository\InsuranceClaim\InsuranceClaimRepository;
use App\Service\Service;

/**
 * Class ClaimService
 * @method InsuranceClaim|false hash($hash)
 * @package App\Service\Claim
 */
class ClaimService extends Service
{

    /**
     * @Inject
     * @var InsuranceClaimRepository
     */
    public $entityRepository;

}
