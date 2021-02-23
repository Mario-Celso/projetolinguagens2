<?php


namespace App\Service\SafeCompany;


use App\Entity\SafeCompany\SafeCompany;
use App\Repository\SafeCompany\SafeCompanyRepository;
use App\Service\Service;
use DI\Annotation\Inject;

/**
 * Class ProposalService
 * @method SafeCompany|false hash($hash)
 * @package App\Service\SafeCompany
 */
class SafeCompanyService extends Service
{
    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    public $entityRepository;

}