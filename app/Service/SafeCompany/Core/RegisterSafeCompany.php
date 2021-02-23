<?php


namespace App\Service\SafeCompany\Core;


use App\Component\Hash;
use App\Entity\SafeCompany\SafeCompany;
use App\Repository\SafeCompany\SafeCompanyRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class RegisterSafeCompany
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    protected SafeCompanyRepository $safeCompanyRepository;

    public function register($data, $company){
        $safeCompany = new SafeCompany();

        $safeCompany->setInsurer($data['insurer']);
        $safeCompany->setCompany($company);
        $safeCompany->setHash(Hash::get($this->safeCompanyRepository));
        $safeCompany->setStatus(SafeCompany::SAFE_COMPANY_STATUS_ACTIVE);

        try{
            $this->entityManager->persist($safeCompany);
            $this->entityManager->flush();

            return $safeCompany;

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}