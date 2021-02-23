<?php


namespace App\Service\Administrator;


use App\Repository\Administrator\AdministratorRepository;
use App\Service\Service;
use DI\Annotation\Inject;

class AdministratorService extends Service
{
    /**
     * @Inject
     * @var AdministratorRepository
     */
    protected $entityRepository;


    public function login($user, $password)
    {
        $adm = $this->entityRepository->findOneBy(['user'=>$user]);

        if(is_object($adm)){
            if ($adm->isAuthentic($password)){
                return $adm;
            }
        }else{
            return false;
        }

    }

}