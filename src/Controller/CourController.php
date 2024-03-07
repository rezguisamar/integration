<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Entity\User;
use App\Form\CourType;
use App\Repository\CourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Route('/cour')]
class CourController extends AbstractController
{
    #[Route('/', name: 'app_cour_index', methods: ['GET'])]
    public function index(CourRepository $courRepository): Response
    {
        $user = $this->getUser();
        return $this->render('cour/index.html.twig', [
            'cours' => $courRepository->findAll(),
            'user' => $user,
        ]);
    }
    

    #[Route('/search', name: 'app_cour_search', methods: ['GET','POST'])]
    public function search(Request $request,CourRepository $courRepository): Response
    {
        $search=$request->request->get('query');
        return $this->render('cour/indexBack.html.twig', [
            'cours' => $courRepository->search($search),
        ]);
    }


    #[Route('/cb', name: 'app_cour_index_back', methods: ['GET'])]
    public function indexBack(CourRepository $courRepository): Response
    {
        return $this->render('cour/indexBack.html.twig', [
            'cours' => $courRepository->findAll(),
        ]);
    }

    #[Route('/filtre', name: 'app_cour_filtre', methods: ['GET' ,'POST'])]
    public function filtre(CourRepository $courRepository,Request $request): Response
    {
        $filtre=$request->request->get('filtre');
        
        return $this->render('cour/indexBack.html.twig', [
            'cours' => $courRepository->findByNiveau($filtre),
        ]);
    }
    #[Route('/filtreCateg', name: 'app_cour_filtre_categ', methods: ['GET' ,'POST'])]
    public function filtreC(CourRepository $courRepository,Request $request): Response
    {
        $filtre=$request->request->get('filtre_adresse');
        
        return $this->render('cour/indexBack.html.twig', [
            'cours' => $courRepository->findByCateg($filtre),
        ]);
    }

    #[Route('/new', name: 'app_cour_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cour = new Cour();
        $form = $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdfFile = $form->get('pdfpath')->getData();

           
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
    
                
                $cour->setPdfpath($fileName);
            }
            $date = new \DateTimeImmutable();
            $cour->setCreatedAt($date);
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('app_cour_index_back', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cour/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }
    #[Route('/pdf/{id}', name: 'pdf_show', methods: ['GET'])]
    public function PdfShow(Cour $cour): Response
    {
$pdfPath = $this->getParameter('kernel.project_dir') . '/public/'.$cour->getPdfpath();
    

if (!file_exists($pdfPath)) {
    throw $this->createNotFoundException('The PDF file does not exist');
}


$response = new BinaryFileResponse($pdfPath);
$response->headers->set('Content-Type', 'application/pdf');


return $response;
    }

    #[Route('/{id}', name: 'app_cour_show', methods: ['GET'])]
    public function show(Cour $cour): Response
    {
        return $this->render('cour/show.html.twig', [
            'cour' => $cour,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_cour_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cour $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);
        $date = $cour->getCreatedAt();


        if ($form->isSubmitted() && $form->isValid()) {
            
        
            $cour->setCreatedAt($date);
            $entityManager->flush();

            return $this->redirectToRoute('app_cour_index_back', [], Response::HTTP_SEE_OTHER);
            
        }

        return $this->renderForm('cour/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cour_delete', methods: ['POST'])]
    public function delete(Request $request, Cour $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cour_index_back', [], Response::HTTP_SEE_OTHER);
    }
}
