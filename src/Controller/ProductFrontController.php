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



#[Route('/products')]
class ProductFrontController extends AbstractController
{
    #[Route('/', name: 'app_product', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $user=$this->getUser();
        return $this->render('product_front/index.html.twig', [
            'products' => $productRepository->findAll(),
            'user' => $user,
        ]);
    }


}
