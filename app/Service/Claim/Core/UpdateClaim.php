<?php


namespace App\Service\Claim\Core;


use App\Component\Hash;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Service\Claim\ClaimDocumentService;
use App\Service\Claim\ClaimThirdDocumentService;
use Doctrine\ORM\EntityManager;

class UpdateClaim
{
    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var RegisterClaimObservation
     */
    private RegisterClaimObservation $registerClaimObservation;

    /**
     * @Inject
     * @var InsuranceClaimThirdParty
     */
    private InsuranceClaimThirdParty $thirdPartyRepository;

    /**
     * @Inject
     * @var ClaimDocumentService
     */
    private ClaimDocumentService $claimDocumentService;

    /**
     * @Inject
     * @var ClaimThirdDocumentService
     */
    private ClaimThirdDocumentService $claimThirdDocumentService;

    /**
     * @Inject
     * @var RegisterClaimThird
     */
    private RegisterClaimThird $registerClaimThird;

    /**
     * @param $data
     * @param InsuranceClaim $claim
     * @return InsuranceClaim
     * @throws \Exception
     */
    public function update($data, InsuranceClaim $claim): InsuranceClaim
    {
        $claim->setUpdatedAt(new \DateTime());

        foreach ($data['obstitle'] as $t_key => $obst) {
            if (!empty($obst) || !empty($data['observation'][$t_key])) {
                $this->registerClaimObservation->register($obst, $data['observation'][$t_key], $data['date'][$t_key],$t_key, $claim);
            }
        }


        $claim->setStatus($data['status']);
        if ($data['status'] == 3) {
            $claim->setDeletedAt(new \DateTime());
        }


        $this->claimDocumentService->updateDocument($data);

        try {
            $this->entityManager->persist($claim);
            $this->entityManager->flush();

            return $claim;

        } catch
        (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

}