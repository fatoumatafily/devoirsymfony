<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'Veuillez entrer une adresse email valide.',
                    ]),
                    new NotNull([
                        'message' => 'L\'adresse email ne doit pas être vide.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer un login valide.',
                    ])
                ],
                'required' => false,
            ])
            ->add('login', TextType::class, [
                'attr' => [
                    'placeholder' => 'Login',
                ],
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9]{3,20}$/',
                        'message' => 'Le login doit contenir entre 3 et 20 caractères, sans espaces.',
                    ]),
                    new NotNull([
                        'message' => 'Le login ne doit pas être vide.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe valide.',
                    ])
                ],
                'required' => false,
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Password',
                ],
                'label' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial.',
                    ]),
                    new NotNull([
                        'message' => 'Le mot de passe ne doit pas être vide.',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez confirmer le mot de passe.',
                    ])
                ],
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
