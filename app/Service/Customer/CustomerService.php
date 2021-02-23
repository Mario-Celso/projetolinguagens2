<?php

namespace App\Service\Customer;

use App\Entity\Customer\Customer;
use App\Repository\Customer\CustomerRepository;
use App\Service\Service;

/**
 * Class CustomerService
 * @method Customer|false hash($hash)
 * @package App\Service\Customer
 */
class CustomerService extends Service
{

    /**
     * @Inject
     * @var CustomerRepository
     */
    public $entityRepository;

}
