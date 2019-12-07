<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Form\PlaceType;
use App\Entity\Category;
use App\EventSubscriber\Form\ArtworkFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Le Nom ne peut pas être null'
                    ]),
                    new NotBlank([
                        'message' => 'Le Nom ne peut pas être vide'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'La description ne peut être null'
                    ]),
                    new NotBlank([
                        'message' => 'La description ne peut être vide'
                    ]),
                    new Length([
                        'min' => 20,
                        'minMessage' => "La description doit comporter {{ limit }} caractères au minimum"
                    ])
                ]
            ])
            ->add('place', PlaceType::class)
            // ->add('category_type', ChoiceType::class, [
            //     'mapped' => false,
            //     'multiple' => false,
            //     'expanded' => true,
            //     'choices' => [
            //         'Choisir une catégorie' => false,
            //         'Créer une categorie' => true
            //     ]
            // ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous devez sélectionner une catégorie",
                    ])
                ]
            ]);
        // ->add('category_name', null, [
        //     'mapped' => false,
        //     'attr' => [
        //         'class' => 'category',
        //         'hidden' => true
        //     ],
        //     'label_attr' => [
        //         'hidden' => true
        //     ]
        // ]);

        $builder->addEventSubscriber(new ArtworkFormSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
