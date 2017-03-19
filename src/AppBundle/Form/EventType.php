<?php

namespace AppBundle\Form;

use AppBundle\Entity\EventCategory;
use AppBundle\Entity\EventGenre;
use AppBundle\Entity\Place;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Event;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('title', TextType::class, [
				'label' => 'Titre',
				'attr' => [
					'placeholder' => 'Nom de l\'événement',

					/*'class' => 'datepicker-here',
					'data-timepicker' => 'true',
					'data-language' => 'fr'*/
				]
			])

			-> add('image', ImageType::class, ['required' => false])
			-> add('type', EntityType::class, [
					'class' => EventGenre::class, // /!\ to avoid pb with this class (EventType)
					'required' => true,
					'choice_label' => 'name',
					'query_builder' => function($entRepo){
						$qb = $entRepo -> createQueryBuilder('eventType');
						$qb -> orderBy("eventType.name", "ASC");
						return $qb;
					}
				])
			-> add('category', EntityType::class, [
					'label' => 'Catégorie',
					'class' => EventCategory::class,
					'required' => false,
					'choice_label' => 'name',
					'expanded' => false,
					'multiple' => false,
					'query_builder' => function($entRepo){
						$qb = $entRepo -> createQueryBuilder('eventCat');
						$qb -> orderBy("eventCat.name", "ASC");
						return $qb;
					}
				])
			-> add('groups', CollectionType::class, array(
				'required' => false,
				'label' => 'Artistes',
				'entry_type' => GroupeType::class,
				'allow_add' => true,
				'allow_delete' => true
			))
			-> add('place', EntityType::class, [
				'label' => 'Lieu',
				'class' => Place::class,
				'required' => true,
				'choice_label' => 'name',
				'expanded' => false,
				'multiple' => false,
				'query_builder' => function($entRepo){
					$qb = $entRepo -> createQueryBuilder('place');
					$qb -> orderBy("place.name", "ASC");
					return $qb;
				}
			])
			/*-> add('place', EntityType::class, [
				'label' => 'Lieu',
				'class' => Place::class,
				'required' => true,
				'choice_label' => 'name',
				'expanded' => false,
				'multiple' => false,
				'query_builder' => function($entRepo){
					$qb = $entRepo -> createQueryBuilder('place');
					$qb -> orderBy("place.name", "ASC");
					return $qb;
				}
			])*/
			-> add('start', DateTimeType::class, [
				'attr'=> [
					'class' => 'datepicker-here',
					'data-timepicker' => 'true',
					'data-language' => 'fr'
				],
				'input' => 'datetime',
				'date_format' => 'dd/MM/yyyy hh:mm',
				'widget' => 'single_text',
				'label' => 'Début'])
			-> add('end', DateTimeType::class, [
				'input' => 'datetime',
				'widget' => 'single_text',
				'label' => 'Fin'])
			-> add('article', TextareaType::class, ['required' => false])
			-> add('price', NumberType::class, ['label' => 'Prix'])
			-> add('mamaEvent', CheckboxType::class, ['required' => false])
//			-> add('submit', SubmitType::class, ['label' => 'Enregistrer'])
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
