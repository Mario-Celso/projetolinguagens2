<?php


namespace App\Service\User\Core;


use App\Repository\User\UserRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use SlimSession\Helper as Session;

class UpdatePasswordUser
{
    /**
     * @Inject
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var Session
     */
    public $session;


    /**
     * @param $data
     * @param $user
     * @return mixed
     * @throws \Exception
     */



    public function update($data, $user){

        if ($user->isAuthentic($data['old_password']))
        {
            if($data['new_password'] == $data['new_password_confirmation'])
            {
                $session = $this->session;
                $user->setPassword($data['new_password']);

            }else{
                throw new \Exception('A senha de confirmação precisa ser o mesmo que a senha nova');
            }

        }else{
            throw new \Exception('A senha inserida está incorreta');
        }

        try{
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $user;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

}