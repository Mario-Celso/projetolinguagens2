<?php


namespace App\Service\Claim\Core;

use App\Component\File;
use App\Component\Hash;
use App\Entity\Customer\Customer;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Entity\Policy\Policy;
use App\Repository\InsuranceClaim\InsuranceClaimRepository;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

/**
 * Class RegisterClaim
 * @package App\Service\Claim\Core
 */
class RegisterClaim
{
    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var InsuranceClaimRepository
     */
    private InsuranceClaimRepository $claimRepository;

    /**
     * @Inject
     * @var InsuranceClaimThirdPartyRepository
     */
    private InsuranceClaimThirdPartyRepository $claimThirdRepository;

    /**
     * @Inject
     * @var RegisterClaimObservation
     */
    private RegisterClaimObservation $registerClaimObservation;

    /**
     * @Inject
     * @var RegisterClaimThird
     */
    protected RegisterClaimThird $registerClaimThird;


    /**
     * @param $data
     * @param Policy $policy
     * @return InsuranceClaim
     * @throws \Exception
     */
    public function register($data, Policy $policy): InsuranceClaim
    {
        $claim = new InsuranceClaim();

        $claim->setHash(Hash::get($this->claimRepository));

        $customer = $policy->getCustomer();
        $claim->setCustomer($customer);
        $claim->setPolicy($policy);
        $claim->setStatus($data['status']);

        $company = $customer->getCompany();
        $claim->setCompany($company);

        $customer->addClaim($claim);
        $policy->addClaims($claim);

        // t_key é o id da observação
        foreach ($data['obstitle'] as $t_key => $obst) {
            if (!empty($obst) || !empty($data['observation'][$t_key])) {
                $this->registerClaimObservation->register($obst, $data['observation'][$t_key], $data['date'][$t_key], $t_key, $claim);
            }
        }


        try {
            $this->entityManager->persist($claim);
            $this->entityManager->persist($customer);
            $this->entityManager->persist($policy);
            $this->entityManager->flush();

            return $claim;

        } catch
        (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}