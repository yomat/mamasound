<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceListener{
	
	private $actif;
	private $templating;
	
	public function __construct($actif, $templating){
		$this->actif = $actif;
		$this->templating = $templating;
	}
	protected function modeMaintenance(Response $response){
		$content = $this ->templating ->render('blog/maintenance.html.twig');
		$response->setContent($content);
		return $response;
	}
	
	public function onKernelResponse(FilterResponseEvent $event){
		// teste si on est sur la requete principale (cf sous-requetes incluses possibles)
		if(!$event->isMasterRequest())
		//if(HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType())
			return;
		if ($this->actif){
			$response = $this->modeMaintenance($event->getResponse());
			$event -> setResponse($response);
		}
	}
}