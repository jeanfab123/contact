<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'placeholder'    => "Pseudo...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('motdepasse', PasswordType::class, [
                'attr' => [
                    'placeholder'    => "Mot de passe...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('confirmation_motdepasse', PasswordType::class, [
                'attr' => [
                    'placeholder'    => "Confirmation du mot de passe...",
                ],
                'label'     => false,
                'required'  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
