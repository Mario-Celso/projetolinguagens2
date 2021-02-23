<?php


namespace App\Service\Customer;


use App\Repository\Customer\CustomerDocumentsRepository;
use App\Service\Service;

class CustomerDocumentService extends Service
{
    /**
     * @Inject
     * @var CustomerDocumentsRepository
     */
    protected $entityRepository;

}