<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse; 

#[Route('/event')]
class EventController extends AbstractController

{
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }
    


    #[Route('/eb', name: 'app_event_index_back', methods: ['GET'])]
    public function indexBack(eventRepository $eventRepository): Response
    {
        return $this->render('event/indexBack.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);


    }
    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index_back', [], Response::HTTP_SEE_OTHER);
        }



        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }


    #[Route('/filtre', name: 'app_event_filtre', methods: ['GET' ,'POST'])]
    public function filtre(EventRepository $eventRepository,Request $request): Response
    {
        $filtre=$request->request->get('filtre');
        
        return $this->render('event/indexBack.html.twig', [
            'events' => $eventRepository->findByCategory($filtre),
        ]);
    }
   
    #[Route('/search', name: 'app_event_search', methods: ['GET','POST'])]
    public function search(Request $request, EventRepository $eventRepository): Response
    {
        $query = $request->request->get('query');
        $events = $eventRepository->search($query);
    
        return $this->render('event/indexBack.html.twig', [
            'events' => $events,
        ]);
    }
    


    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
        
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index_back', [], Response::HTTP_SEE_OTHER);
    }
}
