<?php


namespace App\Service\User\Core;


use App\Entity\User\User;
use App\Repository\User\UserRepository;
use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use SlimSession\Helper as Session;

class UpdateUser
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


    public function update($data, $user)
    {
        $session = $this->session;
        $user->setName($data['name']);
        $session->set('name', $data['name']);
        $user->setStatus($data['status']);

        if ($data['email'] != $user->getEmail()) {
            $anotherUser = $this->userRepository->findOneBy(['email' => $data['email']]);
            if ($anotherUser == null) {
                $user->setEmail($data['email']);
                $session->set('email', $data['email']);

            } else {
                throw new \Exception('Já está em uso este e-mail. Por favor, digite outro e-mail');
            }
        }


        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $user;

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

}