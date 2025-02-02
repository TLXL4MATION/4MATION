<?php

namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return new RedirectResponse($this->generateUrl('app_home'));
        }
        return $this->render('login/login.html.twig', [
            'loginForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'target_path' => $this->generateUrl('admin'),
        ]);
    }
}
