<?php


namespace App\Service\Claim\Core;


use App\Component\Hash;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository;
use App\Service\Claim\ClaimThirdDocumentService;
use App\Service\Claim\ClaimThirdService;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use SlimSession\Helper as Session;

class RegisterClaimThird
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var ClaimThirdService
     */
    protected ClaimThirdService $thirdService;

    /**
     * @Inject
     * @var ClaimThirdDocumentService
     */
    protected ClaimThirdDocumentService $claimThirdDocumentService;

    /**
     * @Inject
     * @var InsuranceClaimThirdPartyRepository
     */
    protected InsuranceClaimThirdPartyRepository $claimThirdRepository;

    /**
     * @Inject
     * @var RegisterClaimThirdObservation
     */
    protected RegisterClaimThirdObservation $registerClaimThirdObservation;

    /**
     * @Inject
     * @var Session
     */
    public $session;

    /**
     * @param $data
     * @param $claim
     * @param null $third
     * @return InsuranceClaimThirdParty|mixed|null
     * @throws ORMException
     * @throws \Exception
     */
    public function register($data , $claim, $third = null): ?InsuranceClaimThirdParty
    {
        if (is_null($third)) {
            $third = new InsuranceClaimThirdParty();
            $third->setHash(Hash::get($this->claimThirdRepository));
        }


        $third->setName($data['name']);
        $third->setDocumentIdentifier($data['document']);

        $third->setInsuranceClaim($claim);
        $claim->addThirdParty($third);

        $this->claimThirdDocumentService->updateDocument($data);

        foreach ($data['obstitle'] as $t_key => $obst) {
            if (!empty($obst) || !empty($data['observation'][$t_key])) {
                $this->registerClaimThirdObservation->register($obst, $data['observation'][$t_key], $data['date'][$t_key], $t_key, $third);
            }
        }

        try {
            $this->entityManager->persist($claim);
            $this->entityManager->persist($third);

            $this->entityManager->flush();

            return $third;
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());

        }
    }

}