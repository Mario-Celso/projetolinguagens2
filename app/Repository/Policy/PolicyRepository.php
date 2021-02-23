<?php

namespace App\Repository\Policy;


use Doctrine\ORM\EntityRepository;

class PolicyRepository extends EntityRepository
{
    public function query($data)
    {

        $qb = $this->_em->createQueryBuilder()
            ->select('p')->from('\App\Entity\Policy\Policy', 'p');

        //a vencer
//        if ($data['type'] == 1){
        $qb->Where($qb->expr()->gte('p.policy_date', ':policy_date_1'))->setParameter('policy_date_1', $data['start']);
        $qb->andWhere($qb->expr()->lte('p.policy_date', ':policy_date_2'))->setParameter('policy_date_2', $data['end'])
        ->andWhere('p.deleted_at IS NULL');

//        $qb->where($qb->expr()->between('p.policy_date',':initialDate',':finalDate'))
//                ->setParameter('initialDate', $data['start'])
//                ->setParameter('finalDate', $data['end'])


//        } elseif ($data['type'] == 2) {
//            //vencidas
//            $qb->where($qb->expr()->between('p.policy_date',':finalDate',':initialDate'))
//                ->setParameter('initialDate', $data['end'])
//                ->setParameter('finalDate', $data['start']);
//        }

        $qb->addOrderBy('p.policy_date', 'DESC');

        return $qb->getQuery()->getResult();
    }
}