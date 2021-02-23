<?php


namespace App\Service\Claim\Core;


use App\Component\Hash;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Entity\InsuranceClaim\InsuranceClaimThirdPartyObservation;
use App\Service\Claim\ClaimThirdObservationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class RegisterClaimThirdObservation
{
    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var ClaimThirdObservationService
     */
    private ClaimThirdObservationService $observationService;

    /**
     * @param $title
     * @param $obs
     * @param $date
     * @param $t_key
     * @param InsuranceClaimThirdParty $claim
     * @return bool
     * @throws \Exception
     */
    public function register($title, $obs, $date, $t_key, InsuranceClaimThirdParty $claim): bool
    {
        if (!is_object($observation = $this->observationService->getEntityRepository()->findOneBy(['hash' => $t_key]))) {
            $observation = new InsuranceClaimThirdPartyObservation();
            $observation->setHash(Hash::get($this->observationService->getEntityRepository()));
        }

        $observation->setTitle($title);
        $observation->setObservation($obs);
        $observation->setDate($this->observationService->convertDate($date));
        $claim->addObservations($observation);

        try {
            $this->entityManager->persist($observation);
            $this->entityManager->persist($claim);

            $this->entityManager->flush();
        } catch (OptimisticLockException | ORMException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        return true;

    }
}