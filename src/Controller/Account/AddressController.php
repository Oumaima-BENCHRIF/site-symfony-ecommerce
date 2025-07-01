<?php

namespace App\Controller\Account;

use App\Classe\Cart;
use App\Entity\Adress;
use App\Entity\User;
use App\Form\AdressUserType;
use App\Form\PasswordUserType;
use App\Repository\AdressRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Function_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AddressController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $EntityManager)
    {
        $this->entityManager=$EntityManager;
    }

    #[Route('/compte/adresses', name: 'app_account_adresses')]
    public function index(): Response
    {
        return $this->render('account/address/index.html.twig');
    }

    #[Route('/compte/adress/delete?{id}', name: 'app_account_adress_delete')]
    public function delete($id,AdressRepository $adressRepository): Response
    {
        $adress= $adressRepository->findOneById($id);
        if(!$adress OR $adress->getUser() !=$this->getUser()){
            // die('Ok')
            return $this->redirectToRoute('app_account_adresses') ;
        }
        $this->addFlash(
            'success',
            'Votre adresse est correctement supprimer '
        );
        $this->entityManager->remove( $adress);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_account_adresses') ;
    }

    #[Route('/compte/adresse/ajouter/{id}', name: 'app_account_adress_form',defaults:['id'=>null])]
    public function form(Request $request , $id,AdressRepository $adressRepository,Cart $cart): Response
    {
        if($id){
            $adress= $adressRepository->findOneById($id);
            if(!$adress OR $adress->getUser() !=$this->getUser()){
                // die('Ok')
                return $this->redirectToRoute('app_account_adresses') ;
            }

        }else{
            $adress=new Adress();
            $adress->setUser( $this->getUser());
        }

    

        $form=$this->createForm(AdressUserType::class,$adress);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist( $adress);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'Votre adresse est correctement sauvgarder '
            );
           
            if( $cart->fullOuantity()>0){
                return $this->redirectToRoute('app_order');
            }
            return $this->redirectToRoute('app_account_adresses');
            
        }

        return $this->render('account/address/form.html.twig',[
            'adressForm'=>$form
        ]);
    }
}
?>