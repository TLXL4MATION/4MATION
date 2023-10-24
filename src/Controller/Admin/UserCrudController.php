<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PlanificateurService;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;



class UserCrudController extends AbstractCrudController
{
    private PlanificateurService $planificateurService;
    private UserRepository $userRepository;


    /**
     * @param PlanificateurService $planificateurService
     * @param UserRepository $userRepository
     */
    public function __construct(PlanificateurService $planificateurService, UserRepository $userRepository)
    {
        $this->planificateurService = $planificateurService;
        $this->userRepository = $userRepository;
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
            EmailField::new('email')
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        return $this->planificateurService->createNewPlanificateurWithPassword();
    }

    /**
     * @param SearchDto $searchDto
     * @param EntityDto $entityDto
     * @param FieldCollection $fields
     * @param FilterCollection $filters
     * @return QueryBuilder
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = $this->userRepository->createQueryBuilder('u');
        $queryBuilder
            ->andWhere('CONTAINS(TO_JSONB(u.roles), :role) = TRUE')
            ->setParameter('role', '["ROLE_PLANNIFICATEUR"]');

        return $queryBuilder;
    }

}
