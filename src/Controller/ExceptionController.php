<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionController extends AbstractController
{
    /**
     * @Route("/_error", name="app_error")
     */
    public function show(Request $request, \Throwable $exception)
    {
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

        if ($statusCode === 404) {
            // Redirigez vers la page spécifique souhaitée ici
            return new RedirectResponse($this->generateUrl('app_home'));
        }

        // Vous pouvez gérer d'autres codes d'erreur ici si nécessaire

        throw $exception; // Si vous ne voulez pas gérer un code d'erreur spécifique, relancez simplement l'exception.
    }
}
