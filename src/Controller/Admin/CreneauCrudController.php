<?php

namespace App\Controller\Admin;

use App\Entity\Creneau;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            AssociationField::new('formateur'),
            AssociationField::new('moduleFormation'),
            AssociationField::new('groupePromotion'),
            TextareaField::new("commentaire")
        ];
    }

}
