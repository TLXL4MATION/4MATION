<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdresseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adresse::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('numero')->setLabel("Numéro de rue"),
            TextField::new('rue'),
            TextField::new('codePostal'),
            TextField::new('ville'),
            TextField::new('pays'),
        ];
    }
}
