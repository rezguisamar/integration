<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Route('/application')]
class ApplicationController extends AbstractController
{
    #[Route('/', name: 'app_application_index', methods: ['GET'])]
    public function index(ApplicationRepository $applicationRepository): Response
    {

        return $this->render('application/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_application_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user=$this->getUser();
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdfFile = $form->get('pdf')->getData();

           
            if ($pdfFile instanceof UploadedFile) {
                
                $fileName = md5(uniqid()) . '.' . $pdfFile->guessExtension();
    
               
                try {
                    $targetDirectory = $this->getParameter('kernel.project_dir') . '/public';
                    $pdfFile->move(
                        $targetDirectory, 
                        $fileName
                    );
                } catch (FileException $e) {
                   
                }
                $application->setPdf($fileName);
            
        } 

            $entityManager->persist($application);
            $entityManager->flush();

            return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('application/new.html.twig', [
            'application' => $application,
            'form' => $form,
            'user'=>$user,
        ]);
}

    #[Route('/{id}', name: 'app_application_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('application/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_application_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Application $application, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('application/edit.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_application_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->request->get('_token'))) {
            $entityManager->remove($application);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
    }


#[Route('/pdf/{id}', name: 'pdf_show', methods: ['GET'])]
public function PdfShow(Application $application): Response
{
$pdfPath = $this->getParameter('kernel.project_dir') . '/public/'.$application->getPdf();


if (!file_exists($pdf)) {
throw $this->createNotFoundException('The PDF file does not exist');
}


$response = new BinaryFileResponse($pdf);
$response->headers->set('Content-Type', 'application/pdf');


return $response;
}
}