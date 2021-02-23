<?php


namespace App\Service\Claim\Core;


use App\Component\Hash;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimObservation;
use App\Repository\InsuranceClaim\InsuranceClaimObservationRepository;
use App\Service\Claim\ClaimObservationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class RegisterClaimObservation
{
    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var ClaimObservationService
     */
    private ClaimObservationService $observationService;

    /**
     * @Inject
     * @var InsuranceClaimObservationRepository
     */
    private InsuranceClaimObservationRepository $observationRepository;

    /**
     * @param $title
     * @param $obs
     * @param $date
     * @param $t_key
     * @param InsuranceClaim $claim
     * @return bool
     * @throws \Exception
     */
    public function register($title, $obs, $date, $t_key, InsuranceClaim $claim): bool
    {
        if (!is_object($observation = $this->observationService->entityRepository->findOneBy(['hash' => $t_key]))) {
            $observation = new InsuranceClaimObservation();
            $observation->setHash(Hash::get($this->observationRepository));
        }

        $observation->setTitle($title);
        $observation->setObservation($obs);
        $observation->setDate($this->convertDate($date));

        $observation->setInsuranceClaim($claim);
        $claim->addObservations($observation);

        try {
            $this->entityManager->persist($observation);
            $this->entityManager->persist($claim);

            $this->entityManager->flush();
        } catch (OptimisticLockException $e) {
            throw new \Exception($e->getMessage());
        } catch (ORMException $e) {
            throw new \Exception($e->getMessage());
        }

        return true;

    }

    public function convertDate($data)
    {
        if ($data == null) {
            return null;
        } else {
            list($d, $m, $Y) = explode('/', $data);
            if (checkdate($m, $d, $Y)) {
                $d = new \Datetime($Y . '-' . $m . '-' . $d);
                return $d;
            }
        }
    }
}