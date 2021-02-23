<?php


namespace App\Service\Proposal;


use App\Repository\Proposal\ProposalDocumentRepository;
use App\Service\Service;

class ProposalDocumentService extends Service
{
    /**
     * @Inject
     * @var ProposalDocumentRepository
     */
    protected $entityRepository;

}