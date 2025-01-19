<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>'Votre adress email',
                'attr'=>[
                    'placeholder'=>'Indequez votre adress email'
                ]
            ])
           // ->add('roles')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 20,
                        ])
                ],
                'first_options'  => [
                    'label' => 'Votre mot de passe',
                    'attr'=>[
                        'placeholder'=>'Choisissez votre mot de passe'
                    ],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr'=>[
                        'placeholder'=>'Confirmez votre mot de passe'
                    ]
                ],
                'mapped' => false,
            ])
            ->add('firstname',TextType::class,[
                'label'=>'Votre prenom',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 20,
                        ])
                ],
                'attr'=>[
                    'placeholder'=>'Indequez votre prenom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>'Votre nom',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 20,
                        ])
                ],
                'attr'=>[
                    'placeholder'=>'Indequez votre nom'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider',
                'attr'=>[
                    'class'=>'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'entityClass' =>  User::class,
                    'fields' => 'email',
                    ])
            ],
            'data_class' => User::class,
        ]);
    }
}
