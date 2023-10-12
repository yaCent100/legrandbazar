<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 2,
                    'max' => 20,
                    'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le nom ne doit pas comporter plus de {{ limit }} caractères.'
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z ]+$/',
                    'message' => 'Le nom ne doit contenir que des lettres et des espaces.'
                ])
            ]])

            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 20,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne doit pas comporter plus de {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z ]+$/',
                        'message' => 'Le nom ne doit contenir que des lettres et des espaces.'
                    ])
                ]

            ])

            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]

            ])

            ->add('code_postal', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])

            ->add('date_naissance', DateType::class, [
                'years' => range(date('Y') - 100, date('Y')), // autorise les dates des 100 dernières années
                'data' => new \DateTime(),
            ])

            ->add('email', EmailType::class)

            ->add('pseudo', TextType::class)

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs password ne sont pas identiques.',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation de mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@$!%*?&)',
                    ]),
                    new Assert\NotCompromisedPassword([
                        'message' => 'Le mot de passe est trop faible, il a été compromis et ne peut pas être utilisé.',
                    ]),

                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'ENVOYER',
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
