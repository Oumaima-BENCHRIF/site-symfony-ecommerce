<?php

namespace App\Controller;

use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HeaderRepository $headerRepository,ProductRepository $productRepository): Response
    {
        // $name='Oumaima';
        // $table=['ab','nl'];
        return $this->render('home/index.html.twig',[
        'headers'=>$headerRepository->findAll(),
        'productsInhomepage'=>$productRepository->findByIsHomepage(true),
        // 'table'=>$table,
        ]);
    }
}
