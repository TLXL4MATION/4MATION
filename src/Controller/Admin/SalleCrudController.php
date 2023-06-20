<?php

namespace App\Controller\Admin;

use App\Entity\Salle;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SalleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Salle::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('numero'),
            AssociationField::new('campus')
                ->setFormTypeOption('choice_label', 'nom'),
        ];
    }
}
