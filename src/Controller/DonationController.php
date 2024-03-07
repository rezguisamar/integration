<?php

namespace App\Controller;

use App\Entity\Charity;
use App\Entity\Donation;
use App\Form\Donation1Type;
use App\Form\DonationType;
use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormTypeInterface;

#[Route('/donation')]
class DonationController extends AbstractController
{
    #[Route('/', name: 'app_donation_index', methods: ['GET'])]
    public function index(DonationRepository $donationRepository): Response
    {
        return $this->render('donation/index.html.twig', [
            'donations' => $donationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_donation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $donation = new Donation();
        $donation->setDate(new \DateTime()); // Set the current date and time

        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCharity = $donation->getCharity(); // Retrieve the selected charity from the donation entity

            // Check if a valid charity is selected
            if (!$selectedCharity) {
                throw $this->createNotFoundException('No charity selected.');
            }

            $entityManager->persist($donation);
            $entityManager->flush();

            return $this->redirectToRoute('app_charity_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('donation/new.html.twig', [
            'donation' => $donation,
            'form' => $form->createView(),
        ]);
    }




    #[Route('/{id}', name: 'app_donation_show', methods: ['GET'])]
    public function show(Donation $donation): Response
    {
        return $this->render('donation/show.html.twig', [
            'donation' => $donation,
        ]);
    }



    /* #[Route('/{id}/edit', name: 'app_donation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Donation1Type::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_donation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation/edit.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }*/

    /* #[Route('/{id}', name: 'app_donation_delete', methods: ['POST'])]
    public function delete(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_donation_index', [], Response::HTTP_SEE_OTHER);
    }*/
}
