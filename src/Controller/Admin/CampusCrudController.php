<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Entity\Campus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            AssociationField::new("adresse")
                ->setCrudController(AdresseCrudController::class)
                ->renderAsEmbeddedForm()
//            CollectionField::new('adresse')
//                ->allowAdd(true)
//                ->useEntryCrudForm()
        ];
    }
}
