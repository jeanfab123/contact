<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder'    => "Email...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder'    => "Nom...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder'    => "Prénom...",
                ],
                'label'     => false,
                'required'  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
