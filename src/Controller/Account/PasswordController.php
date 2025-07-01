<?php

namespace App\Controller\Account;

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


class PasswordController extends AbstractController
{

    private $entityManager;
    
    public function __construct(EntityManagerInterface $EntityManager)
    {
        $this->entityManager=$EntityManager;
    }
    #[Route('/compte/modifier-mot-passe', name: 'app_account_modify_pwd')]
    public function index(Request $request,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();
        // dd($user);
        $form= $this->createForm(PasswordUserType::class,$user,[
            'passwordhasher'=> $userPasswordHasher
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $this->entityManager->flush();
            // dd($form->getData());
            $this->addFlash(
                'success',
                'Votre mot de passe est correctement mise à jour '
            );
        }
        return $this->render('account/password/index.html.twig',[
            "modifyPwd"=>$form->createView()
        ]);
    }

}
?>