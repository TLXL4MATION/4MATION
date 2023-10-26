<?php

// src/Controller/DemandeController.php

namespace App\Controller;

use App\Entity\Formateur;
use App\Entity\User;
use App\Repository\CreneauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DemandeController extends AbstractController
{

    private $creneauRepository;
    private $security;

    public function __construct(CreneauRepository $creneauRepository, Security $security)
    {
        $this->creneauRepository = $creneauRepository;
        $this->security = $security;
    }

    private function estUtilisateurFormateurDuCreneau(int $creneauId): bool
    {
        $user = $this->security->getUser();


        if (!$user) {
            return false; // L'utilisateur n'est pas connecté.
        }

        $creneau = $this->creneauRepository->find($creneauId);

        if (!$creneau) {
            return false; // Le créneau n'existe pas.
        }


        // Compare l'ID du formateur du créneau avec l'ID de l'utilisateur
        if ($creneau->getFormateur()->getUtilisateur()->getId() === $user->getId()) {
            return true; // L'utilisateur est le formateur associé au créneau.
        }

        return false; // L'utilisateur n'est pas le formateur du créneau.
    }


    /**
     * @Route("/accepter-demande/{id}", name="accepter_demande")
     */
    public function accepterDemande(Security $security, Request $request, $id): Response
    {

        if ($this->estUtilisateurFormateurDuCreneau($id)) {
            $this->creneauRepository->setEnvoyeById($id, true);
            return $this->redirectToRoute('app_demandes');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/nombreDemandes", name="accepter_demande")
     */
    public function nombreDemandes(Security $security, Request $request): Response
    {
        $user = $this->security->getUser();

        if ($formateur = $user->getFormateur()) {

            /** @var Formateur $formateur */
            $data = ['nombreDemande' => $formateur->getNombreDemande()];

            return new JsonResponse($data);
        }
        return new JsonResponse(['nombreDemande' => 0]);
    }

    /**
     * @Route("/refuser-demande/{id}", name="refuser_demande")
     */
    public function refuserDemande(Security $security, Request $request, $id): Response
    {
        if ($this->estUtilisateurFormateurDuCreneau($id)) {
            $this->creneauRepository->setEnvoyeById($id, false);
            return $this->redirectToRoute('app_demandes');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
