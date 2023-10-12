<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'disabled' => true,
                'label' => 'Nom'
            ])

            ->add('prenom', TextType::class, [
                'disabled' => true,
                'label' => 'Prénom'
            ])

            ->add('old_adresse', TextType::class, [
                'mapped' => false,
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Entrez votre Adresse actuel'
                ]
            ])

            ->add('old_code_postal', NumberType::class, [
                'mapped' => false,
                'label' => 'Code Postal',
                'attr' => [
                    'placeholder' => 'Entrez votre Code Postal actuel'
                ]
            ])

            ->add('new_adresse', TextType::class, [
                'mapped' => false,
                'label' => 'Nouvelle Adresse',
                'attr' => [
                    'placeholder' => 'Entrez votre nouvelle Adresse'
                ],
                'required' => true
            ])

            ->add('new_code_postal', NumberType::class, [
                'mapped' => false,
                'label' => 'Nouveau Code Postal',
                'attr' => [
                    'placeholder' => 'Entrez votre nouveau Code Postal'
                ],
                'required' => true
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour',
                'attr' => [
                    'class' => 'btn-primary mt-5 col-12'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
