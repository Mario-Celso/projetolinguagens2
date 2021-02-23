<?php

namespace App\Service\Policy;

use App\Entity\Policy\Policy;
use App\Repository\Policy\PolicyRepository;
use App\Service\Service;

/**
 * Class PolicyService
 * @method Policy|false hash($hash)
 * @package App\Service\Policy
 */
class PolicyService extends Service
{

    /**
     * @Inject
     * @var PolicyRepository
     */
    public $entityRepository;

}
