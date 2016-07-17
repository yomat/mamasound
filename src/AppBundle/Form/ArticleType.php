<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Category;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('title', TextType::class)
			    	-> add('content', TextareaType::class)
			    	-> add('author', TextType::class)
			    	-> add('date', DateType::class)
			    	-> add('publication', CheckboxType::class, ['required' => false])
			    	-> add('image', ImageType::class, ['required' => false])
			    	-> add('categories', EntityType::class, 
			    			[
				    			'class' => Category::class, 
				    			'required' => false, 
				    			'choice_label' => 'title',
				    			'expanded' => true,
				    			'multiple' => true,
				    			'query_builder' => function($entRepo){
				    				$qb = $entRepo -> createQueryBuilder('cat');
				    				$qb -> orderBy("cat.title", "ASC");
				    				return $qb;
				    			}
			    			])
			    			
			    	-> add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }
}
