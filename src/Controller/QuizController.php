<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Epreuve;
use App\Entity\Cour;
use App\Form\QuizType;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/quiz')]
class QuizController extends AbstractController
{
    
    #[Route('/Epreuve/fail', name: 'app_quiz_fail', methods: ['GET'])]
    public function fail(Request $request): Response
    { 
        
        return $this->render('quiz/fail.html.twig');
    }




    #[Route('/quizes/{id}', name: 'app_quiz_index', methods: ['GET'])]
    public function index(QuizRepository $quizRepository,Cour $cour): Response
    {
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $cour->getQuizzes(),
        ]);
    }
   
    #[Route('/quizesFront/{id}', name: 'app_quiz_index_front', methods: ['GET'])]
    public function indexFront(QuizRepository $quizRepository,Cour $cour): Response
    {
        $user = $this->getUser();
        return $this->render('quiz/indexFront.html.twig', [
            'quizzes' => $cour->getQuizzes(),
            'user' => $user,
        ]);
    }

    #[Route('/new/{id}', name: 'app_quiz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Cour $cour): Response
    {
            $user = $this->getUser();

        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $d=new \DateTimeImmutable();
            $cour->addQuiz($quiz);
            $quiz->setCourid($cour);
            $quiz->setCreatedAt($d);
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('app_quiz_index', ['id'=>$cour->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quiz/new.html.twig', [
            'cours'=>$cour,
            'quiz' => $quiz,
            'form' => $form,
            'user' => $user,

        ]);
    }
   
    #[Route('/Epreuve/Succes/{id}', name: 'app_quiz_succes', methods: ['GET'])]
    public function Succes(Epreuve $epreuve,Request $request): Response
    {

        $user = $this->getUser();
        return $this->render('quiz/Succes.html.twig', [
            'epreuve' => $epreuve,
            'user' => $user,
        ]);
    }
   
    #[Route('/{id}', name: 'app_quiz_show', methods: ['GET'])]
    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }
    #[Route('/{id}/takequiz', name: 'app_quiz_display', methods: ['GET','POST'])]
    public function DisplayFront(Request $request, Quiz $quiz,EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($request->isMethod('POST')) {
            // Get submitted answers from the form
            $submittedAnswers = $request->request->get('answers');
    
            // Initialize total score
            $totalScore = 0;
    
            // Iterate over each question in the quiz
            foreach ($quiz->getQuestions() as $question) {
                // Check if the submitted answer matches the correct answer
                if (isset($submittedAnswers[$question->getId()]) && $submittedAnswers[$question->getId()] === $question->getReponse()) {
                    // If the answer is correct, add the question's note to the total score
                    $totalScore += $question->getNote();
                }
            }
           if($totalScore>=$quiz->getNote())
           {
            $d=new \DateTimeImmutable();
            $epreuve=new Epreuve();
            $epreuve->setNote($totalScore);
            $epreuve->setEtat(1);
            $epreuve->setQuizid($quiz);
            $epreuve->setDateP($d);
            $entityManager->persist($epreuve);
            $entityManager->flush();
            return $this->redirectToRoute('app_quiz_succes', ['id'=>$epreuve->getId()], Response::HTTP_SEE_OTHER);
           }
           else{
            $d=new \DateTimeImmutable();
            $epreuve=new Epreuve();
            $epreuve->setNote($totalScore);
            $epreuve->setEtat(0);
            $epreuve->setQuizid($quiz);
            $epreuve->setDateP($d);
            $entityManager->persist($epreuve);
            $entityManager->flush();
            return $this->redirectToRoute('app_quiz_fail', [], Response::HTTP_SEE_OTHER);
           }
          
        }
    
        return $this->render('quiz/DisplayFront.html.twig', [
            'quiz' => $quiz,
            'questions' => $quiz->getQuestions(),
            'user' => $user,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_quiz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quiz $quiz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cour_index_back', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form,
        ]);
    }
    #[Route('/Epreuve/pdf/{id}', name: 'app_pdf_epreuve', methods: ['GET','POST'])]
    public function pdfEpreuve(Epreuve $epreuve,Request $request): Response
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $html = $this->renderView('quiz/pdfepreuve.html.twig', [
            'epreuve' => $epreuve,
        ]);
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to browser (inline view)
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }
    #[Route('/{id}', name: 'app_quiz_delete', methods: ['POST'])]
    public function delete(Request $request, Quiz $quiz, EntityManagerInterface $entityManager): Response
    {
        $courid=$quiz->getCourid()->getId();
        if ($this->isCsrfTokenValid('delete'.$quiz->getId(), $request->request->get('_token'))) {
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quiz_index', ['id'=>$courid], Response::HTTP_SEE_OTHER);
    }
  
 
}
