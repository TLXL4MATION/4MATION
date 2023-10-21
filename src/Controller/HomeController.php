<?php

namespace App\Controller;

use App\Enum\RolesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CreneauRepository;
use App\Repository\ModuleFormationRepository;

class HomeController extends AbstractController
{

    private $creneauRepository;
    private $moduleFormationRepository;

    public function __construct(CreneauRepository $creneauRepository, ModuleFormationRepository $moduleFormationRepository)
    {
        $this->creneauRepository = $creneauRepository;
        $this->moduleFormationRepository = $moduleFormationRepository;
    }

    #[Route('/', name: 'app_home')]
    public function redirectHome(): Response
    {
        if ($user = $this->getUser()) {
            if (in_array(RolesEnum::Admin, $user->getRoles(), true) || in_array(RolesEnum::Plannificateur, $user->getRoles(), true)) {
                return new RedirectResponse($this->generateUrl('admin'));
            } else {
                return new RedirectResponse($this->generateUrl('app_home_formateur'));
            }
        } else {
            return new RedirectResponse($this->generateUrl('app_login'));
        }
    }

    #[Route('/formateur', name: 'app_home_formateur')]
    public function index(): Response
    {

        $events = [];
        $eventsFiltered = [];
        $user = $this->getUser();
        // Vérifiez si l'utilisateur a le rôle "Formateur"
        if ($user && in_array(RolesEnum::Formateur, $user->getRoles(), true)) {
            $formateur = $user->getFormateur();


            // Filtrer les événements
            $creneauxFiltres = array_filter($formateur->getCreneaux()->toArray(), function ($creneau) {
                return !$creneau->isEnvoye() && $creneau->isAccepte();
            });

            $events =  $this->getAllEvent($creneauxFiltres);

            $eventsFiltered = $this->filterWeekendCreneaux($events);


            return $this->render('pages/planning.html.twig', [
                'controller_name' => 'HomeController',
                'events' => $eventsFiltered,
                'title' => 'Planning'
            ]);
        }


        return $this->render('pages/planning.html.twig', [
            'controller_name' => 'HomeController',
            'events' => [],
            'title' => 'Planning'
        ]);
    }

    private function filterWeekendCreneaux($events)
    {
        $ev = [];
        foreach ($events as $event) {
            $dateDebut = new \DateTime($event['start']); // Convertir la date de début en objet DateTime
            if (date('N', $dateDebut->getTimestamp()) != 6 && date('N', $dateDebut->getTimestamp()) != 7) {
                // Exclure les événements du samedi (6) et du dimanche (7)
                $ev[] = $event;
            }
        }

        return $ev;
    }
    private function getAllEvent($creneaux)
    {

        $events = [];

        foreach ($creneaux as $creneau) {
            $heureMin = $creneau->getGroupePromotion()->getPromotion()->getCampus()->getHeureMin();
            $heureMax = $creneau->getGroupePromotion()->getPromotion()->getCampus()->getHeureMax();

            $dateDebut = $creneau->getDateDebut();
            $dateFin = $creneau->getDateFin();


            $dateIntermediaire = clone $dateDebut;

            while ($dateIntermediaire <= $dateFin) {
                $event = [
                    'id' => $creneau->getId(),
                    'title' => $creneau->getModuleFormation()->getNom(),
                    'start' => $dateIntermediaire->format('Y-m-d') . ' ' . ($dateIntermediaire == $dateDebut ? $dateDebut->format('H:i:s') : $heureMin->format('H:i:s')),
                    'salle' => "Salle 202",
                    'campus' => "ENI Nantes",
                    'address' => "15 rue des prés",
                    'promoGroup' =>  $creneau->getGroupePromotion()->getNom(),
                    'debut' => $dateIntermediaire->format('Y-m-d') . ' ' . ($dateIntermediaire == $dateDebut ? $dateDebut->format('H:i:s') : $heureMin->format('H:i:s')),
                ];

                if ($dateIntermediaire->format('Y-m-d') == $dateFin->format('Y-m-d')) {
                    $event['end'] = $dateFin->format('Y-m-d') . ' ' . $dateFin->format('H:i:s');
                    $event['fin'] = $dateFin->format('Y-m-d') . ' ' . $dateFin->format('H:i:s');
                } else {
                    $event['end'] = $dateIntermediaire->format('Y-m-d') . ' ' . $heureMax->format('H:i:s');
                    $event['fin'] = $dateIntermediaire->format('Y-m-d') . ' ' . $heureMax->format('H:i:s');
                }

                $events[] = $event;
                $dateIntermediaire->modify('+1 day');
            }
        }

        return $events;
    }


    #[Route('/formateur/cours', name: 'app_cours')]
    public function cours(): Response
    {
        return $this->render('pages/cours.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/formateur/formations', name: 'app_formations')]
    public function formations(): Response
    {
        $formations = [];
        $user = $this->getUser();
        // Vérifiez si l'utilisateur a le rôle "Formateur"
        if ($user && in_array(RolesEnum::Formateur, $user->getRoles(), true)) {
            $formateur = $user->getFormateur();
            $formations = $formateur->getFormationsPossibles();
        }


        // usort($demandes, function ($a, $b) {
        //     return $b['dateHeure'] <=> $a['dateHeure'];
        // });


        return $this->render('pages/formations.html.twig', [
            'controller_name' => 'HomeController',
            'formations' => $formations,
            'title' => 'Mes formations'
        ]);
    }


    #[Route('/formateur/demandes', name: 'app_demandes')]
    public function demandes(): Response
    {
        $demandes = [];
        $user = $this->getUser();
        // Vérifiez si l'utilisateur a le rôle "Formateur"
        if ($user && in_array(RolesEnum::Formateur, $user->getRoles(), true)) {
            $formateur = $user->getFormateur();
            $demandes = $this->creneauRepository->findDemandesByFormateur($formateur);
        }


        // usort($demandes, function ($a, $b) {
        //     return $b['dateHeure'] <=> $a['dateHeure'];
        // });


        return $this->render('pages/demandes.html.twig', [
            'controller_name' => 'HomeController',
            'demandes' => $demandes,
            'title' => 'Demandes de cours'
        ]);
    }
}
