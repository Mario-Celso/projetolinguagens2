<?php


namespace App\Repository\Customer;


use App\Entity\Customer\Customer;
use Doctrine\ORM\EntityRepository;

/**
 * Class CustomerRepository
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @package App\Repository\Customer
 */
class CustomerRepository extends EntityRepository
{

}