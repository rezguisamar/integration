<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccessDeniedController extends AbstractController
{
    #[Route('/access/denied', name: 'app_access_denied')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user && $this->isGranted('ROLE_USER')) {
            return $this->render('error/accessDenied.html.twig');
        }
        return $this->redirectToRoute('app_back_home');
    }
}
