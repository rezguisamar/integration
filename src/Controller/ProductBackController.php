<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products/back')]
class ProductBackController extends AbstractController
{
    #[Route('/', name: 'app_product_back_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product_back/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_back_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        // Create the form without the disponibility field
        $form = $this->createForm(ProductType::class, $product, [
            'include_productdisponibility_field' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Convert the input price value to a float with ".00" appended if necessary
            $productPrice = $this->normalizePrice($product->getProductPrice());

            // Set the normalized price value back to the Product entity
            $product->setProductPrice($productPrice);

            // Persist and flush the Product entity
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_back/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }



//search 
#[Route('/search', name: 'app_product_search', methods: ['GET'])]
public function search(Request $request,ProductRepository $productRepository): Response
{
    $search=$request->request->get('query');
    return $this->render('product_back/index.html.twig', [
        'products' => $productRepository->search($search),
    ]);
}


    private function normalizePrice($price)
    {
        // Convert the price value to float with ".00" appended if necessary
        if (is_numeric($price)) {
            // If the value is an integer, convert it to float with ".00" appended
            return sprintf("%.2f", $price);
        } else {
            // If the value is not numeric, return null or handle the error accordingly
            return null; // or throw an exception, return an error message, etc.
        }
    }

    #[Route('/{id}', name: 'app_product_back_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product_back/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_back/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_back_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
