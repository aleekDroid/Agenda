<?php

namespace App\Form;

use App\Entity\Phone;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhonesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Number', NumberType::class, [
                'required' => true,
                'label' => 'Número de teléfono',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese tu número de teléfono.',
                    'mb-3' => 'mb-3'
                ]
            ])
            ->add('Type', TextType::class, [
                'required' => true,
                'label' => 'Tipo de teléfono',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el tipo de teléfono.',
                    'mb-3' => 'mb-3'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Add Phone',
                'attr' => [
                    'class' => 'btn btn-success',
                    'mb-3' => 'mb-3',
                    'style' => 'margin-top: 15px;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Phone::class,
        ]);
    }
}
