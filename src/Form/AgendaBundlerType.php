<?php

namespace App\Form;

use App\Entity\Agenda\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AgendaBundlerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nombre',
                'attr' => [
                    'class' => 'form-control', 
                    'placeholder' => 'Ingrese el nombre',
                    'mb-3' => 'mb-3'
                ]
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'Apellido',
                'attr' => [
                    'class' => 'form-control', 
                    'placeholder' => 'Ingrese el apellido',
                    'mb-3' => 'mb-3'
                ]
            ])
            ->add('mail', EmailType::class, [
                'required' => true,
                'label' => 'Correo Electrónico',
                'attr' => [
                    'class' => 'form-control', 
                    'placeholder' => 'Ingrese el correo electrónico',
                    'mb-3' => 'mb-3'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Agregar contacto',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'mb-3' => 'mb-3',
                    'style' => 'margin-top: 15px;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
