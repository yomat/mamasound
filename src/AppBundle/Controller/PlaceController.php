<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ArticleType;
use AppBundle\Entity\Article;
use AppBundle\Entity\Event;
use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Place;
use AppBundle\Form\PlaceType;
use AppBundle\Form\CommentType;
use AppBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/mamasound")
 */

class PlaceController extends Controller
{

	/**
	 * @Route("/places", name="places", options={"expose"=true})
	 *
	 */
	public function indexAction(Request $request){

		// events
		$repo = $this -> getDoctrine() -> getManager() -> getRepository('AppBundle:Place');


		if($request->isXmlHttpRequest()) {
			$namePart = $request -> request -> get('namePart');
			/*$term = $request -> request -> get('startWith');
			$array= $this -> getDoctrine() -> getEntityManager()
				->getRepository('menCommandesBundle:commande')
				->listeNature($term);
			*/
			$places = $repo -> getPlacesJSON();
			$response = new JsonResponse($places);
			//$response -> headers -> set('Content-Type', 'application/json');
			return $response;
		}

		$places = $repo -> getPlaces();
		// vue twig
		return $this->render('places/places.html.twig',['places' => $places]); // TODO
	}

	/**
	 * @Route("/placesLike", name="placesLike", options={"expose"=true}, requirements={})
	 *
	 */
	public function indexLikeAction(Request $request){
		$repo = $this -> getDoctrine() -> getManager() -> getRepository('AppBundle:Place');

		// ajax call
		if($request->isXmlHttpRequest()) {
			$search_term = $request -> request -> get('search_term');
			$places = $repo -> getPlacesLikeJSON($search_term);
			$response = new JsonResponse($places);
			//$response -> headers -> set('Content-Type', 'application/json');
			return $response;
		}
		$places = $repo -> getPlaces(); // TODO trancher si on passe l'argument dans la route ! => getPlacesLike()
		// vue twig
		return $this->render('places/places.html.twig',['places' => $places]); // TODO
	}

	/**
	 * @Route("/placeDetail/{id}", options={"expose"=true}, name="place_detail", requirements={"id":"\d+"})
	 */
	public function showDetailPlace(Request $request, $id){
		if($request->getMethod()=="POST"){
			//$id = $request-> get('eventId');

			// récupération de l'event dans le repo
			$repo = $this -> getDoctrine() -> getManager() -> getRepository('AppBundle:Place');
			$place = $repo -> find($id);
			return $this->render('Place/detail.html.twig',[
					'place' => $place
				]
			);
		}
		// récupération de la place dans le repo
		$repo = $this -> getDoctrine() -> getManager() -> getRepository('AppBundle:Place');
		$place = $repo -> find($id);

		// vue twig
		return $this->render('Place/detail.html.twig',[
				'place' => $place
			]
		);
	}

	/**
	 * @Route("/placeDetailSmall/{id}", options={"expose"=true}, name="place_detail_small", requirements={"id":"\d+"})
	 */
	public function placeDetailSmall(Request $request, $id){
		if($request->getMethod()=="POST"){
			//$id = $request-> get('eventId');

			// récupération de l'event dans le repo
			$repo = $this -> getDoctrine() -> getManager() -> getRepository('AppBundle:Place');
			$place = $repo -> find($id);
			return $this->render('Place/detail_small.html.twig',[
					'place' => $place
				]
			);
		}
		// récupération de la place dans le repo
		$repo = $this -> getDoctrine() -> getManager() -> getRepository('AppBundle:Place');
		$place = $repo -> find($id);

		// vue twig
		return $this->render('Place/detail.html.twig',[
				'place' => $place
			]
		);
	}

	/**
	 * @Route("/place/add", name="new_place", options={"expose"=true})
	 * @Template
	 */
	public function addPlaceAction(Request $request){
		$place = new Place();

		$form = $this  -> createForm(PlaceType::class, $place, array(
			'action' => $this->generateUrl('new_place'),
			'method' => 'POST',
		));

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// ... perform some action, such as saving the task to the database
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager -> persist($place);	// mise en persistance de l'objet $article

			$session = $this->get('session');

			try{
				//$event-> setEditDate($event->getDate());
				$entityManager -> flush();
				$session -> getFlashBag()-> add('info', 'Evénement enregistré');
				$session -> getFlashBag()-> add('info', 'avec succès');
				return $this -> redirectToRoute('place_detail', array('id' => $place->getId()) );
			}catch(\PDOException $e){
				$session -> getFlashBag()-> add('error', 'PDOException');
				$session -> getFlashBag()-> add('error', 'PDOException');
			}
		}
		return $this->render('Place/add.html.twig', ['form' => $form->createView()] );
	}

}
