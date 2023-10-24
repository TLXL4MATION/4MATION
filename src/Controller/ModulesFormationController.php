<?php

// src/Controller/ModuleFormationController.php

namespace App\Controller;

use App\Repository\FormateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ModulesFormationController extends AbstractController
{

    private $formateurRepository;
    private $security;

    public function __construct(FormateurRepository $formateurRepository, Security $security)
    {
        $this->formateurRepository = $formateurRepository;
        $this->security = $security;
    }

   


   
    /**
     * @Route("/formationsPossibles/{id}", name="refuser_ModuleFormation")
     */
    public function formationsPossibles(Security $security, Request $request, $id): Response
    {
       
       $formateur = $this->formateurRepository->find($id);


       $moduleChoices = [];
       foreach ($formateur->getFormationsPossibles() as $module) {
           $moduleChoices[$module->getId()] = $module->getNom(); // Adapté à votre entité ModuleFormation
       }

       return new JsonResponse($moduleChoices);
    }
}
