<?php


namespace App\Service\Administrator\Core;


use App\Component\Hash;
use App\Entity\Administrator\Administrator;
use App\Repository\Administrator\AdministratorRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;

class RegisterAdministrator
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var AdministratorRepository
     */
    protected AdministratorRepository $administratorRepository;

    public function register($data)
    {
        if($data['password'] == $data['password_confirmation']){
            $adm = new Administrator();
            $adm->setUser($data['user']);
            $adm->setName($data['name']);
            $adm->setEmail($data['email']);
            $adm->setPassword($data['password']);
            $adm->setHash(Hash::get($this->administratorRepository));
            $adm->setStatus(Administrator::ADMINISTRATOR_STATUS_ACTIVE);

            try{
                $this->entityManager->persist($adm);
                $this->entityManager->flush();

                return $adm;

            }catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
            }

        }else{
            throw new \Exception('As duas senhas precisam ser as iguais');
        }


    }

}