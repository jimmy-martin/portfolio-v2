<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvent;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Nom du projet'
            ])

            ->add('summary', null, [
                'label' => 'Mini-description'
            ])

            ->add('description', null, [
                'label' => 'Description'
            ])

            ->add('github', null, [
                'label' => 'Lien GitHub'
            ])

            ->add('url', null, [
                'label' => 'Lien du site',
            ])

            ->add('image', FileType::class, [
                'label' => 'Screenshot du projet',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez envoyer une image au format jpg/jpeg ou png.',
                    ])
                ]
            ])

            ->add('user', null, [
                'label' => 'Propriétaire du projet'
            ])

            ->add('categories', null, [
                'label' => 'Catégories',
                'multiple' => true,
                'expanded' => true,
            ])

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $project = $event->getData();
                $form = $event->getForm();

                if ($project->getId() !== null) {
                    $form->remove('image');

                    $form->add('image', FileType::class, [
                        'label' => 'Nom du fichier image',
                        'mapped' => false,
                        'required' => false,
                        'constraints' => [
                            new File([
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                ],
                                'mimeTypesMessage' => 'Veuillez envoyer une image au format jpg/jpeg ou png.',
                            ])
                        ]
                    ]);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
