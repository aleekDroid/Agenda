<?php

namespace App\Form;

use App\Entity\Agenda\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\PhonesType;

class AgendaBundlerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'enter_name',
                    'mb-3' => 'mb-3',
                ],
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'last_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'enter_last_name',
                    'mb-3' => 'mb-3',
                ],
            ])
            ->add('mail', EmailType::class, [
                'required' => true,
                'label' => 'email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'enter_email',
                    'mb-3' => 'mb-3',
                ],
            ])
            ->add('phones', CollectionType::class, [
                'label' => 'phones',
                'entry_type' => PhonesType::class,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'save',
                'attr' => [
                    'class' => 'btn btn-success',
                    'mb-3' => 'mb-3',
                    'style' => 'margin-top: 15px;',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain' => 'Agenda',
        ]);
    }
}
