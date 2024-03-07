<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    #[Route('/back', name: 'app_back')]
    public function index(): Response
    {
        $user = $this->getUser();

        // Check if the user has the ROLE_ADMIN role
        if ($user && $this->isGranted('ROLE_ADMIN')) {
            return $this->render('back/index.html.twig', [
                'controller_name' => 'BackController',
            ]);
        }

        return $this->redirectToRoute('app_access_denied');

    }
}
