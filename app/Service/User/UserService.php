<?php

namespace App\Service\User;

use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManager;
use App\Service\Service;

/**
 * Class UserService
 * @package App\Service\User
 */
class UserService extends Service
{

    /**
     * @Inject
     * @var UserRepository
     */
    public $entityRepository;

    public function login($email, $password)
    {
        $user = $this->entityRepository->findOneBy(['email' => $email]);
        $user_name = $this->entityRepository->findOneBy(['name' => $email]);
        if (is_object($user) && $user->getId())
            if ($user->isAuthentic($password))
                return $user;

        if (is_object($user_name) && $user_name->getId())
            if ($user_name->isAuthentic($password))
                return $user_name;

        return false;
    }

    public function user($user)
    {
        $user = $this->entityRepository->findOneBy(['email' => $user]);
        if (is_object($user) && $user->getId())
            return $user;

        return false;
    }

}
