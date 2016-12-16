<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Category;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('Titre', TextType::class)
			-> add('Type', EntityType::class, [
					'class' => EventGenre::class, // /!\ to avoid pb with this class (EventType)
					'required' => true,
					'choice_label' => 'title',
					'expanded' => true,
					'multiple' => false,
					'query_builder' => function($entRepo){
						$qb = $entRepo -> createQueryBuilder('eventType');
						$qb -> orderBy("eventType.title", "ASC");
						return $qb;
					}
				])
			-> add('Genre', EntityType::class, [
					'class' => EventCategory::class,
					'required' => false,
					'choice_label' => 'title',
					'expanded' => true,
					'multiple' => false,
					'query_builder' => function($entRepo){
						$qb = $entRepo -> createQueryBuilder('eventCat');
						$qb -> orderBy("eventCat.title", "ASC");
						return $qb;
					}
				])
			-> add('Début', DateType::class)
			-> add('Fin', DateType::class)
			-> add('Résumé', TextareaType::class)
			-> add('Article', TextareaType::class)
			-> add('Prix', NumberType::class)
			-> add('MamaEvent', CheckboxType::class, ['required' => false])
			-> add('Lieu', EntityType::class, [
					'class' => Place::class,
					'required' => true,
					'choice_label' => 'name',
					'expanded' => true,
					'multiple' => false,
					'query_builder' => function($entRepo){
						$qb = $entRepo -> createQueryBuilder('place');
						$qb -> orderBy("place.name", "ASC");
						return $qb;
					}
				])
			-> add('Artistes', EntityType::class, [
					'class' => Groupe::class,
					'required' => true,
					'choice_label' => 'name',
					'expanded' => true,
					'multiple' => true,
					'query_builder' => function($entRepo){
						$qb = $entRepo -> createQueryBuilder('group');
						$qb -> orderBy("group.name", "ASC");
						return $qb;
					}
				])

			//-> add('image', ImageType::class, ['required' => false])

			//-> add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }
}
