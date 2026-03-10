<?php

namespace App\Form;

use App\Entity\Phone;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
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
                'label' => 'phone_number',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'enter_phone',
                    'mb-3' => 'mb-3'
                ],
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 10,
                        'minMessage' => 'constraints_phone_number',
                        'maxMessage' => 'constraints_phone_number',
                    ]),
                    new Type([
                        'type' => 'numeric',
                        'message' => 'The phone number must be a valid number.',
                    ]),
                ],
            ])
            ->add('Type', TextType::class, [
                'required' => true,
                'label' => 'phone_type',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'enter_phone_type',
                    'mb-3' => 'mb-3'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'add_phone',
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
            'translation_domain' => 'Agenda',
        ]);
    }
}
