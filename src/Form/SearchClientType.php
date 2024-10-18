<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('surname', TextType::class, [
        //     'attr' => [
        //         'placeholder' => 'Surname',
        //     ],
        //     'label' => false,
        //     'required' => false,
        //     'constraints' => [
        //         new NotBlank([
        //             'message' => 'Veuillez entrer un nom valide',
        //         ]),
        //         new NotNull([
        //             'message' => 'Le nom ne doit pas être vide.',
        //         ]),
        //         new Regex([
        //             'pattern' => "/^[\p{L}\p{M}'-]{2,50}$/u",
        //             'message' => 'Veuillez entrer un nom valide (2 à 50 caractères, lettres uniquement).',
        //         ]),
        //     ]
        // ])
        ->add('tel', TextType::class, [
            'attr' => [
                'placeholder' => 'Tel',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le numéro de téléphone ne doit pas être vide.',
                ]),
                new Regex([
                    'pattern' => "/^\+221\s?\d{3}[-\s]?\d{3}[-\s]?\d{3}$/",
                    'message' => 'Please enter a valid phone number',
                ]),
            ],
            'label' => false,
            'required' => false,
        ])
        ->add('Rechercher', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-active bg-first border-first text-gray-100',
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
