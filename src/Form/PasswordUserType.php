<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword',PasswordType::class,[
                'label'=>'Votre mot de passe actuel',
                'attr'=>[
                    'placeholder'=>'Choisissez votre nouveau mot de passe'
                ],
                'mapped' => false,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 20,
                        ])
                ],
                'first_options'  => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr'=>[
                        'placeholder'=>'Choisissez votre nouveau mot de passe'
                    ],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr'=>[
                        'placeholder'=>'Confirmez votre nouveau mot de passe'
                    ]
                ],
                'mapped' => false,
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Mettre a jour mon mot dr passe',
                'attr'=>[
                    'class'=>'btn btn-success'
                ]
            ])
            ->addEventListener(FormEvents::SUBMIT,function(FormEvent $event){

                $form=$event->getForm();
                $user=$form->getConfig()->getOptions()['data'];

                $passwordHasher=$form->getConfig()->getOptions()['passwordhasher'];

                $actualPwd=$form->get('actualPassword')->getData();

                // hash the password (based on the security.yaml config for the $user class)
                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $actualPwd
                );
                // $user->setPassword($hashedPassword);

                if(!$isValid){
                    $form->get('actualPassword')->addError(new FormError("Votre mot de passe actuel n'est pas conforme. Veuillez vérifier votre saisie."));

                }
               
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([ 
            'data_class' => User::class,
            'passwordhasher'=>null,
        ]);
    }
}
