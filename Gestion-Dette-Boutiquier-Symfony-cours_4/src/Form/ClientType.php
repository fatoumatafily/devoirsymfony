<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use App\EventSubscriber\ClientFormSubscriber;
use Symfonycasts\DynamicForms\DependentField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'attr' => ['placeholder' => 'Surname'],
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un nom valide']),
                    new NotNull(['message' => 'Le nom ne doit pas être vide.']),
                    new Regex([
                        'pattern' => "/^[\p{L}\p{M}'-]{2,50}$/u",
                        'message' => 'Veuillez entrer un nom valide (2 à 50 caractères, lettres uniquement).',
                    ]),
                ]
            ])
            ->add('tel', TextType::class, [
                'attr' => ['placeholder' => 'Tel'],
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a valid label']),
                    new Regex([
                        'pattern' => "/^\+221\s?\d{3}[-\s]?\d{3}[-\s]?\d{3}$/",
                        'message' => 'Please enter a valid phone number',
                    ]),
                    new NotNull(['message' => 'Le numéro de téléphone ne doit pas être vide.']),
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => ['placeholder' => 'Adresse'],
                'label' => false,
                'required' => false,
            ])
            ->add('cumulMontantDu', TextType::class, [
                'attr' => ['placeholder' => 'Montant'],
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a valid label']),
                    new Regex([
                        'pattern' => '/^\d+(\.\d{1,2})?$/',
                        'message' => 'Veuillez entrer un montant valide (jusqu\'à 2 décimales).',
                    ]),
                ],
            ])
            ->add('addUser', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'checkbox',
                    'name' => 'choice'
                ]
            ])
            ->add('utilisateur', UserType::class)
            ->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}