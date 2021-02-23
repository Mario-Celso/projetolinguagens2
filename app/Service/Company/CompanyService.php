<?php


namespace App\Service\Company;


use App\Repository\Administrator\AdministratorRepository;
use App\Repository\Company\CompanyRepository;
use App\Service\Service;
use DI\Annotation\Inject;

class CompanyService extends Service
{
    /**
     * @Inject
     * @var CompanyRepository
     */
    public $entityRepository;




}