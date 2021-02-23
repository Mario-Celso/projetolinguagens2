<?php


namespace App\Service\Policy\Core;

use App\Component\File;
use App\Component\Hash;
use App\Entity\Customer\Customer;
use App\Entity\Policy\Policy;
use App\Entity\Proposal\Proposal;
use App\Repository\Policy\PolicyRepository;
use App\Repository\SafeCompany\SafeCompanyRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

/**
 * Class RegisterPolicy
 * @package App\Service\Policy\Core
 */
class RegisterPolicy
{
    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var PolicyRepository
     */
    private PolicyRepository $policyRepository;

    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    private SafeCompanyRepository $safeCompanyRepository;

    /**
     * @param $data
     * @param Proposal $proposal
     * @return Policy
     * @throws \Exception
     */
    public function register($data, $proposal)
    {
        $policy = new Policy();
        $customer = $proposal->getCustomer();

        $policy->setCustomer($customer);
        $policy->setProposal($proposal);
        $proposal->addPolicies($policy);
        $policy->setStatus(Policy::STATUS_ACTIVE);
        $policy->setPlate($data['plate']);
        $policy->setChassis($data['chassis']);
        $policy->setPolicyNumber($data['policy_number']);
        $policy->setHash(Hash::get($this->policyRepository));
        $policy->setObservation($data['observations']);
        $policy->setBranch($data['branch']);

        $safeCompany = $this->safeCompanyRepository->findOneBy(['hash'=> $data['safe_company']]);
        $policy->setSafeCompany($safeCompany);

        $company = $customer->getCompany();
        $policy->setCompany($company);

        $customer->addPolicy($policy);

        try {
            $this->entityManager->persist($policy);
            $this->entityManager->persist($customer);
            $this->entityManager->persist($proposal);
            $this->entityManager->flush();

            return $policy;

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

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