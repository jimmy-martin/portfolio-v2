<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'mapped' => false,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])
            ->add('firstname', null, [
                'label' => 'Prénom',
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('age', null, [
                'label' => 'Âge',
                'attr' => [
                    'min' => 0,
                ],
                'constraints' => [
                    new Range([
                        'min' => 0,
                    ]),
                ]
            ])
            ->add('profil', null, [
                'label' => 'Profil',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('github', null, [
                'label' => 'Lien du profil GitHub',
            ])
            ->add('twitter', null, [
                'label' => 'Lien du profil Twitter',
            ])
            ->add('linkedin', null, [
                'label' => 'Lien du profil Linkedin',
            ])
            ->add('presentation', null, [
                'label' => 'Présentation',
            ])
            ->add('image', null, [
                'label' => 'Image',
            ])
            ->add('skills', null, [
                'label' => 'Compétences',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('softwares', null, [
                'label' => 'Logiciels',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('operatingSystems', null, [
                'label' => 'Systèmes d\'exploitation',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
