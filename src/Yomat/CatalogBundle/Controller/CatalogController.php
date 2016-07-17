<?php
/**
 * Created by PhpStorm.
 * User: hb
 * Date: 19/05/2016
 * Time: 09:53
 */

namespace Yomat\CatalogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends Controller
{
    /**
     * @Route(  "/catalog/{page}", name="catalog",
     *          defaults={"page":1}, requirements={"page":"\d+"})
     */
    public function indexAction(Request $request, $page)
    {
        return $this->render('YomatCatalogBundle::index.html.twig');
    }
}