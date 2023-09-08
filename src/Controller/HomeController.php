<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Security $security): Response
    {
        return $this->render('pages/planning.html.twig', [
            'controller_name' => 'HomeController',
            
        ]);
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
