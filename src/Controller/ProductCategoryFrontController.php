<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\ProductCategory;
use App\Form\ProductCategoryType;
use App\Repository\ProductCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;



#[Route('/categories', name: 'app_product_category_front')]
class ProductCategoryFrontController extends AbstractController
{
    #[Route('/', name: 'app_product_category_front_index', methods: ['GET'])]
    public function index(ProductCategoryRepository $productCategoryRepository): Response
    {
        $user=$this->getUser();
        return $this->render('product_category_front/index.html.twig', [
            'product_categories' => $productCategoryRepository->findAll(),
            'user' => $user,
        ]);
    }
}
