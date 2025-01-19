<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }
    
    #[Route('/compte/modifier-mot-passe', name: 'app_account_modify_pwd')]
    public function password(Request $request,UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $EntityManager): Response
    {
        $user = $this->getUser();
        // dd($user);
        $form= $this->createForm(PasswordUserType::class,$user,[
            'passwordhasher'=> $userPasswordHasher
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $EntityManager->flush();
            // dd($form->getData());
            $this->addFlash(
                'success',
                'Votre mot de passe est correctement mise à jour '
            );
        }
        return $this->render('account/password.html.twig',[
            "modifyPwd"=>$form->createView()
        ]);
    }
}
