<?php

namespace App\Controller\Admin;

use App\Entity\GroupePromotion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroupePromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupePromotion::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            AssociationField::new('promotion')
                ->setFormTypeOption('choice_label', 'nom'),
        ];
    }

}
