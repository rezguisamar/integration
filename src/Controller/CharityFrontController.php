<?php

namespace App\Controller;

use App\Entity\Charity;
use App\Form\Charity1Type;
use App\Repository\CharityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/charity/front')]
class CharityFrontController extends AbstractController
{
    #[Route('/all', name: 'app_charity_front_index', methods: ['GET'])]
    public function index(CharityRepository $charityRepository): Response
    {
        $user = $this->getUser();
        return $this->render('charity_front/index.html.twig', [
            'charities' => $charityRepository->findAll(),
            'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_charity_front_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $charity = new Charity();
        $form = $this->createForm(CharityType::class, $charity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier téléchargé depuis le formulaire
            $file = $form->get('picture')->getData();

            //handle photos upload second fucntion 
            $file = $form->get('picture')->getData(); // Get the uploaded file from the form
            if ($file) {
                //Handle photos upload
                $filename = md5(uniqid()) . '.' . $file->guessExtension();


                $file->move($this->getParameter('uploads_directory'), $filename);
                $charity->setPicture($filename);
            }




            // Persistez et flushz l'entité charity
            $entityManager->persist($charity);
            $entityManager->flush();

            // Rediriger vers la page d'index des charity
            return $this->redirectToRoute('app_charity_index', [], Response::HTTP_SEE_OTHER);
        }

        // Afficher le formulaire
        return $this->renderForm('charity/new.html.twig', [
            'charity' => $charity,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_charity_front_show', methods: ['GET'])]
    public function show(Request $request, EntityManagerInterface $entityManager, Charity $charities): Response
    {


        return $this->render('charity_front/show.html.twig', [
            'charity' => $charities,
        ]);
    }

    /* #[Route('/{id}/edit', name: 'app_charity_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Charity $charity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Charity1Type::class, $charity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_charity_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('charity_front/edit.html.twig', [
            'charity' => $charity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_charity_front_delete', methods: ['POST'])]
    public function delete(Request $request, Charity $charity, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $charity->getId(), $request->request->get('_token'))) {
            $entityManager->remove($charity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_charity_front_index', [], Response::HTTP_SEE_OTHER);
    }*/
}
