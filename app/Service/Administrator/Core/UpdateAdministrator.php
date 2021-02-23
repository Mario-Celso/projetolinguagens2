<?php


namespace App\Service\Administrator\Core;


use App\Entity\Administrator\Administrator;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class UpdateAdministrator
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;


    public function update($data, $adm)
    {
        $adm->setUser($data['user']);
        $adm->setEmail($data['email']);
        $adm->setName($data['name']);
        $adm->setPassword($data['password']);
        $adm->setStatus($data['status']);

        try{
            $this->entityManager->persist($adm);
            $this->entityManager->flush();

            return $adm;

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

}