<?php

namespace App\Controller\Admin;

use App\Entity\Creneau;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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
            AssociationField::new('sallesSecondaires')->setFormTypeOption('attr.id', 'Creneau_salleSecondaire')->hideOnIndex(),
            AssociationField::new('formateur')->addCssClass('formateur_custom'),
            AssociationField::new('moduleFormation')->addCssClass('module_custom')->renderAsNativeWidget()->setLabel("Formation"),
            AssociationField::new('groupePromotion'),
            TextareaField::new("commentaire")->hideOnIndex()->setLabel("Modalités / Commentaire"),
            BooleanField::new("envoye")->hideOnIndex()->setLabel("Demander validation au formateur"),
            BooleanField::new("accepte")->hideOnIndex()->setLabel("Imposer le créneau au formateur"),
            BooleanField::new("envoye")->onlyOnIndex()->setLabel("Demande acceptée"),
            BooleanField::new("accepte")->onlyOnIndex()->setLabel("Demande en attente"),

        ];
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addCssFile('https://code.jquery.com/jquery-3.6.0.min.js')->addJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.3/dist/js/tom-select.complete.min.js')->addJsFile('js/custom.js'); // Chemin vers votre fichier JavaScript

    }

}
