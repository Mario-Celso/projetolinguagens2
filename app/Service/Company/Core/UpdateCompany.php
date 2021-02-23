<?php


namespace App\Service\Company\Core;


use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class UpdateCompany
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    public function update($data, $company){

        $company->setName($data['name']);
        $company->setDocument($data['document']);
        $company->setStatus($data['status']);

        try{
            $this->entityManager->persist($company);
            $this->entityManager->flush();

            return $company;

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}