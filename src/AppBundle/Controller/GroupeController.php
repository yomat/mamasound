<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Groupe;
use AppBundle\Form\GroupeType;

/**
 * Groupe controller.
 *
 * @Route("/mamasound/groupes")
 */
class GroupeController extends Controller
{
    /**
     * Lists all Groupe entities.
     *
     * @Route("/index", name="groupe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groupes = $em->getRepository('AppBundle:Groupe')->findAll();

        return $this->render('groupe/index.html.twig', array(
            'groupes' => $groupes,
        ));
    }

    /**
     * @Route("/groupLike", name="groupesLike", options={"expose"=true}, requirements={})
     *
     */
    public function indexLikeAction(Request $request){
        $repo = $this -> getDoctrine() -> getManager() -> getRepository('AppBundle:Groupe');

        // ajax call
        if($request->isXmlHttpRequest()) {
            $search_term = $request -> request -> get('search_term');
            $groupes = $repo -> getGroupesLikeJSON($search_term);
            $response = new JsonResponse($groupes);
            //$response -> headers -> set('Content-Type', 'application/json');
            return $response;
        }

        $groupes = $repo -> getGroupes();
        // vue twig
        return $this->render('groupe/index.html.twig',['groupes' => $groupes]); // TODO
    }
    
    /**
     * Creates a new Groupe entity.
     *
     * @Route("/new", name="new_group", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request){
        $groupe = new Groupe();

        $form = $this  -> createForm(GroupeType::class, $groupe, array(
            'action' => $this->generateUrl('new_group'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);

            $entityManager->flush();

            return $this->redirectToRoute('groupe_show', array('id' => $groupe->getId()));
        }

        return $this->render('groupe/new.html.twig', ['form' => $form->createView()] );

    }

    /**
     * Finds and displays a Groupe entity.
     *
     * @Route("/{id}", name="groupe_show")
     * @Method("GET")
     */
    public function showAction(Groupe $groupe)
    {
        $deleteForm = $this->createDeleteForm($groupe);

        return $this->render('groupe/show.html.twig', array(
            'groupe' => $groupe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Groupe entity.
     *
     * @Route("/{id}/edit", name="groupe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Groupe $groupe)
    {
        $deleteForm = $this->createDeleteForm($groupe);
        $editForm = $this->createForm('AppBundle\Form\GroupeType', $groupe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('groupe_edit', array('id' => $groupe->getId()));
        }

        return $this->render('groupe/edit.html.twig', array(
            'groupe' => $groupe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Groupe entity.
     *
     * @Route("/{id}", name="groupe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Groupe $groupe)
    {
        $form = $this->createDeleteForm($groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($groupe);
            $em->flush();
        }

        return $this->redirectToRoute('groupe_index');
    }

    /**
     * Creates a form to delete a Groupe entity.
     *
     * @param Groupe $groupe The Groupe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Groupe $groupe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groupe_delete', array('id' => $groupe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
