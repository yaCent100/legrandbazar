<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'veuillez écrire votre message ici'
                ]
            ])
            ->add('sender', HiddenType::class)
            ->add('creatAt', HiddenType::class)
            ->add('submit', SubmitType::class, [

                'label' => 'ENVOYER',
                'attr' => [
                    'class' => 'btn-primary col-12'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
