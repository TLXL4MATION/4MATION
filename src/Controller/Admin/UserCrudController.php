<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\RolesEnum;
use App\Service\PlanificateurService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    private PlanificateurService $planificateurService;

    /**
     * @param PlanificateurService $planificateurService
     */
    public function __construct(PlanificateurService $planificateurService)
    {
        $this->planificateurService = $planificateurService;
    }
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('campus')
                ->setFormTypeOption('choice_label', 'nom'),
            TextField::new('email'),
            ArrayField::new('roles')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        return $this->planificateurService->createNewPlanificateurWithPassword();
    }

}
