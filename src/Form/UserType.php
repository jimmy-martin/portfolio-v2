<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('firstname')
            ->add('lastname')
            ->add('age')
            ->add('profil')
            ->add('email')
            ->add('github')
            ->add('twitter')
            ->add('linkedin')
            ->add('presentation')
            ->add('image')
            ->add('skills')
            ->add('softwares')
            ->add('operatingSystems')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
