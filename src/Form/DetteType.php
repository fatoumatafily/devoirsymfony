<?php

namespace App\Form;

use App\Entity\Dette;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montantTotal', TextType::class, [
                'attr' => [
                    'placeholder' => 'Montant total',
                ],
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+(\.\d{1,2})?$/',
                        'message' => 'Veuillez entrer un montant valide (jusqu\'à 2 décimales).',
                    ]),
                ],
            ])
            ->add('montantVerser', TextType::class, [
                'attr' => [
                    'placeholder' => 'Montant versé',
                ],
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+(\.\d{1,2})?$/',
                        'message' => 'Veuillez entrer un montant valide (jusqu\'à 2 décimales).',
                    ]),
                ],
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dette::class,
        ]);
    }
}
