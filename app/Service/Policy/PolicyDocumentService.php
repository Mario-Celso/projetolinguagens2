<?php


namespace App\Service\Policy;


use App\Repository\Policy\PolicyDocumentRepository;
use App\Service\Service;

class PolicyDocumentService extends Service
{
    /**
     * @Inject
     * @var PolicyDocumentRepository
     */
    public $entityRepository;

}