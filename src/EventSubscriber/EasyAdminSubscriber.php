<?php

namespace App\EventSubscriber;

use App\Entity\Formateur;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class EasyAdminSubscriber implements EventSubscriberInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private MailerInterface $mailer;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'setFormateurPassword',
        ];
    }

    public function setFormateurPassword(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Formateur) {
            $userGenerated = $this->generateRandomString(4)."@test.fr";
            $passwordGenerated = $this->generateRandomString(10);
            $user = new User();
            $user->setEmail($userGenerated);
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $passwordGenerated
                )
            );
            $email = (new TemplatedEmail())
                ->from('test@dlr-peugeot.fr')
                ->to('delaroche.leo@sfr.fr')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Votre inscription a 4mation')
                ->text('Sending emails is fun again!')
                ->htmlTemplate('mailTemplate/formateurInscription.html.twig')
                ->context([
                    'username' => $userGenerated,
                    'password' => $passwordGenerated
                ]);

            $this->mailer->send($email);

            $user->setRoles(["FORMATEUR"]);
            $entity->setUtilisateur($user);
        }
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
