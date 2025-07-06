<?php

namespace App\Controller\Account;


use App\Entity\Adress;
use App\Entity\User;
use App\Form\AdressUserType;
use App\Form\PasswordUserType;
use App\Repository\AdressRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Function_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HomeController extends AbstractController
{
   
    
    #[Route('/compte', name: 'app_account')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders=$orderRepository->findBy([
            'user'=>$this->getUser(),
            'state'=>[2,3]
        ]);

        return $this->render('account/index.html.twig',[
            'orders'=>$orders
        ]);
    }
    
   
}
