<?php

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('acceuil/index.html.twig', [
            'user' => $user,
            'controller_name' => 'AcceuilController',
        ]);
    }
}
