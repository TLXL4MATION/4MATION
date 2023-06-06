<?php

namespace App\Controller\Admin;

use App\Entity\GroupePromotion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GroupePromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupePromotion::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
