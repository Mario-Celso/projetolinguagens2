<?php


namespace App\Service\User\Core;


use App\Component\Hash;
use App\Entity\User\User;
use App\Repository\User\UserRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use SlimSession\Helper as Session;

class RegisterUser
{
    /**
     * @Inject
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @Inject
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @Inject
     * @var Session
     */
    public $session;


    public function register($data,$company)
    {
        $user = new User();
        $registered = false;

        if($data['password'] == $data['password_confirmation']){
            $anotherUser = $this->userRepository->findOneBy(['email' => $data['email']]);
            if ($anotherUser == null) {
                $user->setEmail($data['email']);
                $user->setName($data['name']);
                $user->setPassword($data['password']);
                $user->setHash(Hash::get($this->userRepository));
                $user->setCompany($company);
                $user->setStatus(User::USER_STATUS_ACTIVE);
                $registered = true;

            } else {
                throw new \Exception('Já está em uso este e-mail. Por favor, digite outro e-mail');
            }

        }else{
            throw new \Exception('As duas senhas precisam ser iguais');
        }
        if($registered){
            try{
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $user;
            }catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
            }
        }


    }

}