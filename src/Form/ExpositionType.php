<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Exposition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExpositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'tinymce'],

            ])
            ->add('place', PlaceType::class)
            ->add('artworks', EntityType::class, [
                'class' => Artwork::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez sélectionner une catégorie",
                    ])
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exposition::class,
        ]);
    }
}
