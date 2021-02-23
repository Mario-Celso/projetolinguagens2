<?php

namespace App\Repository\Proposal;


use App\Entity\Proposal\Proposal;
use Doctrine\ORM\EntityRepository;

class ProposalRepository extends EntityRepository
{
    /**
     * @return int|mixed|string
     */
    public function searchForApprovedProposals($company)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('p')->from('\App\Entity\Proposal\Proposal', 'p')
            ->join('p.customer', 'c')
        ;

        $qb->select(array('p'))
            ->where($qb->expr()->eq('p.status', ':status'))->setParameter('status', Proposal::PROPOSAL_STATUS_APPROVED)
            ->andwhere($qb->expr()->eq('p.company', ':company'))->setParameter('company', $company);
        $qb->orderBy('c.first_name', 'ASC');

        return $qb->getQuery()->getResult();
    }

}