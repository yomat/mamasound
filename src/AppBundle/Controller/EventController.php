<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ArticleType;
use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;

/**
 * @Route("/mamasound")
 */

class EventController extends Controller
{
	protected $nbArticlesByPage = 3;

	/**
	 * @Route("/events/all/{date}", name="all_events", defaults={"date":null})
	 */
	public function listEventsAction(Request $request, $date){
		// date
		$strFormat = 'Y-m-d H:i:s';
		$strDate = !is_null($date) ? date( $strFormat, $date ) : date( $strFormat ) ;

		
		// events
		$events = $this -> getDoctrine() -> getManager()
						-> getRepository('AppBundle:Event')
						-> getEvents($strDate);

		// vue twig
		return $this->render('events/events.html.twig',[
				'date' => $strDate,
				'events' => $events
			]
		);
	}

	/**
	 * @Route("/events/concert{date}", name="concerts", defaults={"date":null})
	 */
	public function listConcertsAction(Request $request, $date){
		// date
		$strFormat = 'Y-m-d H:i:s';
		$strDate = !is_null($date) ? date( $strFormat, $date ) : date( $strFormat ) ;


		// events
		$events = $this -> getDoctrine() -> getManager()
			-> getRepository('AppBundle:Event')
			-> getEvents($strDate);

		// vue twig
		return $this->render('events/concerts.html.twig',[
				'date' => $strDate,
				'events' => $events
			]
		);
	}

	/**
	 * @Route("/events/expo/{date}", name="expos", defaults={"date":null})
	 */
	public function listExposAction(Request $request, $date){
		// date
		$strFormat = 'Y-m-d H:i:s';
		$strDate = !is_null($date) ? date( $strFormat, $date ) : date( $strFormat ) ;


		// events
		$events = $this -> getDoctrine() -> getManager()
			-> getRepository('AppBundle:Event')
			-> getEvents($strDate);

		// vue twig
		return $this->render('events/expos.html.twig',[
				'date' => $strDate,
				'events' => $events
			]
		);
	}

	/**
	 * @Route("/events/theatre/{date}", name="theatres", defaults={"date":null})
	 */
	public function listTheatresAction(Request $request, $date){
		// date
		$strFormat = 'Y-m-d H:i:s';
		$strDate = !is_null($date) ? date( $strFormat, $date ) : date( $strFormat ) ;


		// events
		$events = $this -> getDoctrine() -> getManager()
			-> getRepository('AppBundle:Event')
			-> getEvents($strDate);

		// vue twig
		return $this->render('events/theatres.html.twig',[
				'date' => $strDate,
				'events' => $events
			]
		);
	}

    /**
     * @Route("/articles/{id}", name="blog_detail", requirements={"id":"\d+"})
     * 
     */
    public function detailAction(Request $request, $id){
    	// Récupération de l'article
    	$articleRepository = $this 	-> getDoctrine() -> getManager()
    								-> getRepository('AppBundle:Article');
    	$article = $articleRepository -> find ($id);
    	
    	// ajout de commentaire
    	$comment = new Comment();
    	$form = $this->createForm(CommentType::class, $comment);
    	// envoie par POST
		if($request->getMethod()=="POST"){	
			$form->handleRequest($request);
	    	if ($form->isSubmitted() && $form->isValid()) {
	    		$comment->setArticle($article); // liaison $comment<->$article
	    		// ... perform some action, such as saving the task to the database
	    		$entityManager = $this->getDoctrine()->getManager();
	    		$entityManager -> persist($comment);	// mise en persistance de l'objet $comment
	    	
	    		$session = $this->get('session');
	    	
	    		try{
	    			
	    			$entityManager -> flush();
	    			$session -> getFlashBag()-> add('info_comment', 'Commentaire enregistré');
	    			return $this -> redirectToRoute('blog_detail', array('id' => $article->getId()) );
	    		}catch(\PDOException $e){$session -> getFlashBag()-> add('error', 'PDOException');}
	    	}
		}
		//retour pour les appels GET
    	return $this->render('blog/detail.html.twig', 
    			[	'article'	=> $article,
					'form'		=> $form->createView()
    			]);
    }

    /**
     * @Route("/articles/add", name="blog_add_article")
     */
    public function addArticleAction(Request $request){
    	$article = new Article();
    	$form = $this->createForm(ArticleType::class, $article);
    	 
    	$form->handleRequest($request);
    		
    	if ($form->isSubmitted() && $form->isValid()) { //if($request->getMethod()=="POST")
    		// ... perform some action, such as saving the task to the database
    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager -> persist($article);	// mise en persistance de l'objet $article
    		
    		$session = $this->get('session');
    		
    		try{
    			$article->setEditDate($article->getDate());
    			$entityManager -> flush();
    			$session -> getFlashBag()-> add('info', 'Article enregistré');
    			$session -> getFlashBag()-> add('info', 'avec succès');
    			return $this -> redirectToRoute('blog_detail', array('id' => $article->getId()) );
    		}catch(\PDOException $e){
    			$session -> getFlashBag()-> add('error', 'PDOException');
    			$session -> getFlashBag()-> add('error', 'PDOException');
    		}
    	}
    	return $this->render('blog/articles/add.html.twig', ['form' => $form->createView()] );
    }

    /**
     * @Route("/articles/delete/{id}", name="blog_delete_article", requirements={"id":"\d+"})
     */
    public function deleteArticleAction(Request $request, $id){
    	$entityManager = $this -> getDoctrine() -> getManager();
    	$repository = $entityManager -> getRepository('AppBundle:Article');
    	$article = $repository -> find ($id);
    	$entityManager -> remove( $article );
    	try{
    		$entityManager -> flush();
    	}catch(\PDOException $e){
    		
    	}
    	return $this->render('blog/articles/delete.html.twig',
    			['id' => $id]
    			);
    }
    
    /**
     * @Route("/articles/edit/{id}", name="blog_edit_article", requirements={"id":"\d+"})
     * @Method("GET")
     */
    public function editArticleAction(Request $request, $id){
    	$entityManager = $this -> getDoctrine() -> getManager();
    	$repository = $entityManager -> getRepository('AppBundle:Article');
    	$article = $repository -> find ($id);
    	
    	$form = $this->createForm(ArticleType::class, $article);
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) { //if($request->getMethod()=="POST")
    		// ... perform some action, such as saving the task to the database
    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager -> persist($article);	// mise en persistance de l'objet $article
    	
    		$session = $this->get('session');
    	
    		try{
    			$article->setEditDate($article->getDate());
    			$entityManager -> flush();
    			$session -> getFlashBag()-> add('info', 'Article mis à jour');
    			$session -> getFlashBag()-> add('info', 'avec succès');
    			return $this -> redirectToRoute('blog_detail', array('id' => $article->getId()) );
    		}catch(\PDOException $e){
    			$session -> getFlashBag()-> add('error', 'PDOException');
    			$session -> getFlashBag()-> add('error', 'PDOException');
    		}
    	}
    	return $this->render('blog/articles/edit.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * 
     * @Route("/articles/edit/{id}", name="blog_edit_article_post", requirements={"id":"\d+"})
     * @Method("POST")
     */
    public function editArticlePostAction(Request $request, $id){
    	$entityManager = $this -> getDoctrine() -> getManager();
    	$repository = $entityManager -> getRepository('AppBundle:Article');
    	$article = $repository -> find ($id);
    	 
    	$form = $this->createForm(ArticleType::class, $article);
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) { //if($request->getMethod()=="POST")
    		// ... perform some action, such as saving the task to the database
    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager -> persist($article);	// mise en persistance de l'objet $article
    		 
    		$session = $this->get('session');
    		 
    		try{
    			$article->setEditDate($article->getDate());
    			$entityManager -> flush();
    			$session -> getFlashBag()-> add('info', 'Article mis à jour');
    			$session -> getFlashBag()-> add('info', 'avec succès');
    			return $this -> redirectToRoute('blog_edit_article_post', array('id' => $article->getId()) );
    		}catch(\PDOException $e){
    			$session -> getFlashBag()-> add('error', 'PDOException');
    			$session -> getFlashBag()-> add('error', 'PDOException');
    		}
    	}
    	return $this->render('blog/articles/edit.html.twig', ['form' => $form->createView()]);
    }

    public function footerAction(Request $request) {
    	$repository = $this -> getDoctrine()
					    	-> getManager()
					    	-> getRepository('AppBundle:Article');
    	$last_articles = $repository -> findBy(	array('publication' => true),
												array('date' => 'desc'),
    											3,	// nb elem
    											0); // offset
    	
    	return $this->render('blog/footer.html.twig', ['articles' => $last_articles] );
    }


    /**
     * @Route("/articles/category/{id}", name="blog_articles_from_category", requirements={"id":"\d+"})
     */
    // return all the articles tagged by a category
    public function articlesFromCategoryAction(Request $request, $id){
    	// Récupération de la category
    	$category = $this 	-> getDoctrine() -> getManager()
    						-> getRepository('AppBundle:Category')
    						-> find ($id);
    	
    	$articles = $this 	-> getDoctrine() -> getManager()
    						-> getRepository('AppBundle:Article')
    						-> getArticlesByCategory($category);
    	//return $this->render('blog/index.html.twig', ['articles' => $articles] );
    	$articleCount = $this 	-> getDoctrine() -> getManager()
    							-> getRepository('AppBundle:Article')
    							-> countArticlesByCategory($category);
    	
    	return $this->render('blog/articles_from_category.html.twig',
    			[	'articles' => $articles,
    				'category' => $category,
    				'articleCount' => $articleCount
    			]);
    }

    /**
     * @Route("/mailto", name="mailto_send")
     */
    public function envoyerMailAction()
    {
        
    }
}
