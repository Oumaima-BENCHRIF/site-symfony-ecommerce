<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class OrderController extends AbstractController
{
    #[Route('/commande/Livraison', name: 'app_order')]
    public function index(): Response
    {
        $addresses=$this->getUser()->getAdresses();

        if(count($addresses)==0){
            return $this->redirectToRoute('app_account_adress_form');
        }

        $form = $this->createForm(OrderType::class, null, [
            'addresses' =>  $addresses,
            'action' =>  $this->generateUrl('app_order_summary')
        ]);

        return $this->render('order/index.html.twig', [
            'deliverForm' =>  $form->createView(),
        ]);
    }

    #[Route('/commande/recapilatif', name: 'app_order_summary')]
    public function add(Request $request,Cart $cart,EntityManagerInterface $EntityManager): Response
    {
        if($request->getMethod()!='POST'){
            return $this->redirectToRoute('app_cart');
        }

        $carts=$cart->getCart();

        $form = $this->createForm(OrderType::class, null, [
            'addresses' => $this->getUser()->getAdresses(),
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() || !$form->isValid()) {

            $addressObj=$form->get('addresses')->getData();

            $address=  $addressObj->getLastname().'<br/>';
            $address.= $addressObj->getAdress().'<br/>';
            $address.= $addressObj->getPostal().''.$addressObj->getCity().'<br/>';
            $address.= $addressObj->getCountry().'<br/>';
            $address.= $addressObj->getPhone().'<br/>';


            $order = new Order();

            $order->setUser($this->getUser());
            $order->setCreatedAt(new \DateTime());
            $order->setState(1);
            $order->setCarrierName($form->get('carriers')->getData()->getName());
            $order->setCarrierPrice($form->get('carriers')->getData()->getPrice());
            $order->setDelivery( $address);
            // dd( $order);

            foreach($carts as $product){
                // dd($product);
                $orderDetail= new OrderDetail();
                $orderDetail->setProductName($product['object']->getName());
                $orderDetail->setProductIllustration($product['object']->getIllustration());
                $orderDetail->setProductPrice($product['object']->getPrice());
                $orderDetail->setProductTva($product['object']->getTVA());
                $orderDetail->setProductQuantity($product['qty']);
                $order->addOrderDetail($orderDetail);
            }
            $EntityManager->persist($order);
            //enregitrer les donner
            $EntityManager->flush();
          

        }
    
        return $this->render('order/summary.html.twig', [
            'choices' => $form->getData(),
            'cart'=>$carts,
            'totalWt' => $cart->getTotalWT()
        ]);
    }
}
