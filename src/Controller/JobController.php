<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/job')]
class JobController extends AbstractController
{



    #[Route('/', name: 'app_job_index', methods: ['GET'])]
    public function index(JobRepository $jobRepository): Response
    {
        $user=$this->getUser();
        return $this->render('job/index.html.twig', [
            'jobs' => $jobRepository->findAll(),
            'user'=>$user,
            
        ]);
    }



    #[Route('/', name: 'app_job_index', methods: ['GET'])]
    public function paginator(JobRepository $jobRepository,PaginatorInterface  $paginator, Request $request): Response
    {
        $user = $this->getUser();

        $job = $jobRepository->findAll();
        $pagination = $paginator->paginate(
            $jobRepository->paginationQuery(), /* query NOT result */
            $request->query->get('page', 1),
            1
        );

        return $this->render('job/index.html.twig', [
            'job' => $jobRepository->findAll(),
            'pagination' => $pagination,
            'user' => $user,

        ]);
        
      
        
    }



    #[Route('/new', name: 'app_job_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $job= $form->getData();
        
        if($picture = $form['picture']->getData()) {
            $fileName =md5(uniqid()).'.'.$picture->guessExtension();
            $picture->move($this->getParameter('photo_dir'), $fileName);
            
            $job->setPicture($fileName);
            
        } 


        


            $entityManager->persist($job);
            $entityManager->flush();

            return $this->redirectToRoute('app_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job/new.html.twig', [
            'job' => $job,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_show', methods: ['GET'])]
    public function show(Job $job): Response
    {
        $user=$this->getUser();
        return $this->render('job/show.html.twig', [
            'job' => $job,
            'user'=>$user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_job_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Job $job, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job/edit.html.twig', [
            'job' => $job,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_delete', methods: ['POST'])]
    public function delete(Request $request, Job $job, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            $entityManager->remove($job);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_job_index', [], Response::HTTP_SEE_OTHER);
    }
}
