<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder'    => "Titre...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('adresse', TextareaType::class, [
                'attr' => [
                    'placeholder'    => "Adresse...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('codepostal', TextType::class, [
                'attr' => [
                    'placeholder'    => "Code Postal...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'placeholder'    => "Ville...",
                ],
                'label'     => false,
                'required'  => true,
            ])
            ->add('pays', TextType::class, [
                'attr' => [
                    'placeholder'    => "Pays...",
                ],
                'label'     => false,
                'required'  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
