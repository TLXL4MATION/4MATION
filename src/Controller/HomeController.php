<?php

namespace App\Controller;

use App\Enum\RolesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Security $security): Response
    {
        $events = [];
        $user = $this->getUser();
        // Vérifiez si l'utilisateur a le rôle "Formateur"
        if ($user && in_array(RolesEnum::Formateur, $user->getRoles(), true)) {
            $formateur = $user->getFormateur();

            $events =  $this->getAllEvent($formateur->getCreneaux());

            $eventsFiltered = $this->filterWeekendCreneaux($events);

            // $events = [];
            // foreach ($formateur->getCreneaux() as $creneau) {
            //     $events[] = [
            //         'id' => $creneau->getId(),
            //         'title' => $creneau->getCommentaire(),
            //         'start' => $creneau->getDateDebut()->format('Y-m-d H:i:s'),
            //         'end' => $creneau->getDateFin()->format('Y-m-d H:i:s'),
            //     ];
            // }
        }


        return $this->render('pages/planning.html.twig', [
            'controller_name' => 'HomeController',
            'events' => $eventsFiltered,

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
                ];

                if ($dateIntermediaire->format('Y-m-d') == $dateFin->format('Y-m-d')) {
                    $event['end'] = $dateFin->format('Y-m-d') . ' ' . $dateFin->format('H:i:s');
                } else {
                    $event['end'] = $dateIntermediaire->format('Y-m-d') . ' ' . $heureMax->format('H:i:s');
                }

                $events[] = $event;
                $dateIntermediaire->modify('+1 day');
            }
        }

        return $events;
    }



    #[Route('/cours', name: 'app_cours')]
    public function cours(): Response
    {
        return $this->render('pages/cours.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/formations', name: 'app_formations')]
    public function formations(): Response
    {
        return $this->render('pages/formations.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    #[Route('/demandes', name: 'app_demandes')]
    public function demandes(): Response
    {
        return $this->render('pages/demandes.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
