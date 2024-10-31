<?php

namespace App\Form;

use App\Entity\ClientSearchDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchTerm', TextType::class, [
                'attr' => [
                    'class' => 'input input-bordered bg-gray-100 w-24 md:w-auto',
                    'placeholder' => 'Rechercher par nom ou téléphone',
                ],
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-Z0-9_-]{3,20}$/",
                        'message' => 'Please enter a valid nickname (3-20 characters, letters, numbers, underscores, or hyphens).',
                    ])
                ],
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
            'data_class' => ClientSearchDTO::class,
        ]);
    }
}
