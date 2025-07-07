<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InvoiceController extends AbstractController
{
    #[Route('/compte/facture/impression/{id_order}', name: 'app_invoice_customer')]
    public function index(OrderRepository $orderRepository,$id_order): Response
    {
        $order=$orderRepository->findOneById($id_order);

        if(!$order){
            return $this->redirectToRoute('app_account');
        }
        
        if($order->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_account');
        }

        $dompdf = new Dompdf();

        $html=$this->renderView('invoice/index.html.twig',[
            'order'=>$order,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrail');

        $dompdf->render();

        $dompdf->stream('facture.pdf', [
            'Attachment.php' => false,
        ]);

        exit();

    }
}
