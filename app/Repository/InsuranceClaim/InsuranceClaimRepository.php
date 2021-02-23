<?php


namespace App\Repository\InsuranceClaim;


use Doctrine\ORM\EntityRepository;

class InsuranceClaimRepository extends EntityRepository
{

    public function search($company)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('c.first_name','c.last_name', 'c.document', 'ic.hash', 'ic.status', 'ic.created_at', 'ic.deleted_at', 'p.plate', 'p.chassis',
                 'p.policy_number' )
            ->from('\App\Entity\InsuranceClaim\InsuranceClaim', 'ic')
            ->join('ic.customer', 'c')
            ->join('ic.policy', 'p')
        ;
        $qb->where($qb->expr()->eq('p.company', ':company'))->setParameter('company', $company);
        $qb->andWhere($qb->expr()->isNull('ic.deleted_at'));

        return $qb->getQuery()->getResult();
    }

}