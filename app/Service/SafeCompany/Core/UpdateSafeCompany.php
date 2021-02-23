<?php


namespace App\Service\SafeCompany\Core;


use App\Component\Hash;
use App\Entity\SafeCompany\SafeCompany;
use App\Repository\SafeCompany\SafeCompanyRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class UpdateSafeCompany
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

    public function update($data, $safeCompany){

        $safeCompany->setInsurer($data['insurer']);
        $safeCompany->setStatus($data['status']);

        try{
            $this->entityManager->persist($safeCompany);
            $this->entityManager->flush();

            return $safeCompany;

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}