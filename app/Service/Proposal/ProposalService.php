<?php

namespace App\Service\Proposal;

use App\Entity\Proposal\Proposal;
use App\Repository\Proposal\ProposalRepository;
use App\Service\Service;

/**
 * Class ProposalService
 * @method Proposal|false hash($hash)
 * @package App\Service\Proposal
 */
class ProposalService extends Service
{

    /**
     * @Inject
     * @var ProposalRepository
     */
    public $entityRepository;

}
