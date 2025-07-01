<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\User;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdressUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname',TextType::class,[
                'label'=>'Votre Prenom',
                'attr'=>[
                    'placeholder'=>'Indiquer votre prenom...'
                ]
            ])
            ->add('adress',TextType::class,[
                'label'=>'Votre adresse',
                'attr'=>[
                    'placeholder'=>'Indiquer votre adresse...'
                ]
            ])
            ->add('postal',TextType::class,[
                'label'=>'Votre postal',
                'attr'=>[
                    'placeholder'=>'Indiquer votre postal...'
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>'Votre ville',
                'attr'=>[
                    'placeholder'=>'Indiquer votre ville...'
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>'Votre pays',
                'attr'=>[
                    'placeholder'=>'Indiquer votre prenom...'
                ]
            ])
            ->add('phone',TextType::class,[
                'label'=>'Votre Téléphone',
                'attr'=>[
                    'placeholder'=>'Indiquer votre téléphones'
                ]
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ->add('submit',SubmitType::class,[
                'label'=>'Sauvgarder',
                'attr'=>[
                    'class'=>'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
