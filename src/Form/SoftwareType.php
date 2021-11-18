<?php

namespace App\Form;

use App\Entity\Software;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SoftwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
            ])
            ->add('add', SubmitType::class, [
                'label' => 'Ajouter',
            ])
            ->add('add_again', SubmitType::class, [
                'label' => 'Ajouter et revenir à la page d\'ajout',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $software = $event->getData();
                $form = $event->getForm();

                if ($software->getId() != null) {
                    $form->remove('add');
                    $form->remove('add_again');
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Software::class,
        ]);
    }
}
