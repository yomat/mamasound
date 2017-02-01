<?php

namespace AppBundle\Form;

use AppBundle\Entity\Place;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('name', TextType::class, ['label' => 'Nom'])
			-> add('latitude', NumberType::class)
			-> add('longitude', NumberType::class)
			-> add('elevation', NumberType::class)
			-> add('address', TextType::class, ['label' => 'Adresse'])
			-> add('short', TextareaType::class, ['label' => 'Présentation courte'])
			-> add('article', TextareaType::class, ['label' => 'Présentation détaillée'])
			-> add('partenaire', CheckboxType::class, ['required' => false])

            -> add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;

    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Place'
        ));
    }
}
