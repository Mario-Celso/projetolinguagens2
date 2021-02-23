<?php


namespace App\Service\Policy\Core;

use App\Component\File;
use App\Entity\Policy\Policy;
use App\Repository\SafeCompany\SafeCompanyRepository;
use App\Service\Policy\PolicyDocumentService;
use Doctrine\ORM\EntityManager;

/**
 * Class UpdatePolicy
 * @package App\Service\Policy\Core
 */
class UpdatePolicy
{

    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var PolicyDocumentService
     */
    protected PolicyDocumentService $policyDocumentService;

    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    protected SafeCompanyRepository $safeCompanyRepository;

    /**
     * @param $data
     * @param Policy $policy
     * @return Policy
     * @throws \Exception
     */
    public function update($data, $policy): ?Policy
    {
        $policy->setObservation($data['observations']);
        $policy->setUpdatedAt(new \DateTime());
        $safeCompany = $this->safeCompanyRepository->findOneBy(['hash'=> $data['safe_company']]);
        $policy->setSafeCompany($safeCompany);

        $this->policyDocumentService->updateDocument($data);
        $policy->setPlate($data['plate']);
        $policy->setChassis($data['chassis']);
        $policy->setPolicyNumber($data['policy_number']);
        $policy->setObservation($data['observations']);
        $policy->setBranch($data['branch']);
        $policy->setStatus($data['status']);
        if ($data['status'] == Policy::STATUS_DELETED) {
            $policy->setDeletedAt(new \DateTime());
        }
        try {
            $this->entityManager->persist($policy);
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