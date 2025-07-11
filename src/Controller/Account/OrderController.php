<?php

namespace App\Controller\Account;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/compte/commande/{id_order}', name: 'app_account_order')]
    public function index($id_order,OrderRepository $orderRepository): Response
    {

        $order=$orderRepository->findOneBy([
            'user'=>$this->getUser(),
            'id'=>$id_order
        ]);

        if(!$order){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('account/order/index.html.twig', [
            'order' => $order,
        ]);
    }
}
