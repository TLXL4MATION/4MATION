<?php
// src/Security/UserChecker.php
namespace App\Security;

use App\Entity\User as AppUser;

// Vérifiez le chemin vers votre entité User
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // Vérifiez si l'utilisateur est actif
        if ($user->getFormateur() && !$user->getFormateur()->isActif()) {
            // jetez une exception si vous voulez empêcher la connexion
            throw new CustomUserMessageAuthenticationException('Votre compte est désactivé.');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
    }
}

