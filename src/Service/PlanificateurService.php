<?php

namespace App\Service;

use App\Enum\RolesEnum;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PlanificateurService
{
    const MAIL = "noreply.4mation@gmail.com";
    private UserPasswordHasherInterface $userPasswordHasher;
    private MailerInterface $mailer;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->mailer = $mailer;
    }

    /**
     * @return User
     */
    public function createNewPlanificateurWithPassword(): User
    {
        $user = new User();
        $passwordGenerated = $this->generateRandomString(10);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $passwordGenerated
            )
        );

        $user->setRoles([RolesEnum::Plannificateur]);

        return $user;
    }

    private function generateRandomString($length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
