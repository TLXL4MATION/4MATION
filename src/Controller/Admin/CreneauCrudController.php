<?php

namespace App\Controller\Admin;

use App\Entity\Creneau;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class CreneauCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Creneau::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('dateDebut'),
            DateTimeField::new('dateFin'),
            AssociationField::new('sallePrincipale')->setFormTypeOption('attr.id', 'Creneau_sallePrincipale'),
            AssociationField::new('sallesSecondaires')->setFormTypeOption('attr.id', 'Creneau_salleSecondaire'),
            AssociationField::new('formateur'),
            AssociationField::new('moduleFormation'),
            AssociationField::new('groupePromotion'),
            TextareaField::new("commentaire")->hideOnIndex()->setLabel("Modalités / Commentaire"),
            BooleanField::new("accepte"),
            BooleanField::new("envoye"),
        ];
    }

}
