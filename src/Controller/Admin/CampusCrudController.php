<?php

namespace App\Controller\Admin;

use App\Entity\Campus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class CampusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Campus::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TimeField::new('heureMin'),
            TimeField::new('heureMax'),
            AssociationField::new("adresse")
                ->onlyOnForms()->renderAsEmbeddedForm(AdresseCrudController::class),
            AssociationField::new("adresse")
                ->hideOnForm()->renderAsNativeWidget()
        ];
    }
}
