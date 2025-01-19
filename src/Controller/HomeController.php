<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // $name='Oumaima';
        // $table=['ab','nl'];
        return $this->render('home/index.html.twig',[
        // 'name'=>$name,
        // 'table'=>$table,
        ]);
    }
}
