<?php


namespace App\Service\Claim\Core;


use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class DeleteClaimThird
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var InsuranceClaimThirdPartyRepository
     */
    protected InsuranceClaimThirdPartyRepository $thirdRepository;

    /**
     * @param $third
     * @return mixed
     * @throws \Exception
     */

    public function delete($third){
        $third->setDeletedAt(new \DateTime());

        try{
            $this->entityManager->persist($third);
            $this->entityManager->flush();

            return $third;
        }catch
        (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}