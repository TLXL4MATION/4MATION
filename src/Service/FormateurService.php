<?php

namespace App\Service;

use App\Entity\Formateur;
use App\Enum\RolesEnum;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FormateurService
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
     * @return Formateur
     */
    public function createNewFormateurWithPassword(): Formateur
    {
        $formateur = new Formateur();
        $user = new User();
        $passwordGenerated = $this->generateRandomString(10);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $passwordGenerated
            )
        );

        $user->setRoles([RolesEnum::Formateur]);
        $formateur->setUtilisateur($user);

        return $formateur;
    }

    /**
     * @param Formateur $formateur
     * @return void
     * @throws TransportExceptionInterface
     */
    public function sendMailForNewFormateur(Formateur $formateur): void
    {
        $mail = $formateur->getUtilisateur()->getEmail();
        $email = (new TemplatedEmail())
            ->from(self::MAIL)
            ->to($mail)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Votre inscription a 4mation')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('mailTemplate/formateurInscription.html.twig')
            ->context([
                'username' => $mail,
            ]);

        $this->mailer->send($email);
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
