<?php


namespace App\Service\Company\Core;


use App\Component\Hash;
use App\Entity\Company\Company;
use App\Repository\Company\CompanyRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class RegisterCompany
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;


    /**
     * @param $data
     * @return Company
     * @throws \Exception
     */



    public function register($data)
    {
        $company = new Company();

        $company->setName($data['name']);
        $company->setDocument($data['document']);
        $company->setHash(Hash::get($this->companyRepository));
        $company->setStatus(Company::COMPANY_STATUS_ACTIVE);

        try{
            $this->entityManager->persist($company);
            $this->entityManager->flush();

            return $company;

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

}