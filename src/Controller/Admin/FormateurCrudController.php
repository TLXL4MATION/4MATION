<?php

namespace App\Controller\Admin;

use App\Entity\Formateur;
use App\Entity\ModuleFormation;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new("id")
                ->hideOnForm(),
            TextField::new("nom", "Nom"),
            TextField::new("prenom", "Prénom"),
            AssociationField::new('campusPrincipal')
                ->setFormTypeOption('choice_label', 'nom'),
            AssociationField::new('formationsPossibles')
                ->setFormTypeOption('choice_label', 'nom'),
            AssociationField::new('creneaux')
                ->setFormTypeOption('choice_label', 'nom'),
        ];
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
