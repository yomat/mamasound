<?php
/**
 * Created by PhpStorm.
 * User: yomat
 * Date: 03/02/17
 * Time: 04:38
 */

namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $authenticationUtils = $this->get('security.authentication_utils');
            //return $this->redirectToRoute('logout', array('username' => $authenticationUtils->getLastUsername()));
            return $this->render('UserBundle:Security:logout.html.twig', array(
                'username' => $authenticationUtils->getLastUsername()
            ));
            return new Response("<p>YO</p>");//$this->redirectToRoute('app');
        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('UserBundle:Security:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }
}
