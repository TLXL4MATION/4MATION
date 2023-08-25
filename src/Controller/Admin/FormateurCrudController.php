<?php

namespace App\Controller\Admin;

use App\Entity\Formateur;
use App\Entity\ModuleFormation;
use App\Entity\User;
use App\Service\FormateurService;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class FormateurCrudController extends AbstractCrudController
{

    private FormateurService $formateurService;

    /**
     * @param FormateurService $formateurService
     */
    public function __construct(FormateurService $formateurService)
    {
        $this->formateurService = $formateurService;
    }


    public static function getEntityFqcn(): string
    {
        return Formateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new("nom", "Nom"),
            TextField::new("prenom", "Prénom"),
            AssociationField::new("adresse")
                ->onlyOnForms()->renderAsEmbeddedForm(AdresseCrudController::class),
            AssociationField::new("adresse")
                ->hideOnForm()->renderAsNativeWidget(),
            AssociationField::new('campusPrincipal')
                ->setFormTypeOption('choice_label', 'nom'),
            AssociationField::new('formationsPossibles')
                ->setFormTypeOption('choice_label', 'nom'),
            AssociationField::new('utilisateur')
                ->onlyOnForms()->renderAsEmbeddedForm(UserCrudController::class),
            BooleanField::new("actif", "Activé ?")
                ->hideOnForm()
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        return $this->formateurService->createNewFormateurWithPassword();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        try {
            $entityManager->persist($entityInstance);
            $entityManager->flush();
            $this->formateurService->sendMailForNewFormateur($entityInstance);
        } catch (Exception $e) {
            $this->addFlash('warning', 'Impossible de créer le Formateur, un formateur avec le même email existe déjà');
        } catch (TransportExceptionInterface $e) {
            $this->addFlash('warning', "Impossible d'envoyer le mail");
        }
    }
}
