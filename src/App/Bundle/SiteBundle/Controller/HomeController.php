<?php

namespace App\Bundle\SiteBundle\Controller;

use App\Bundle\SiteBundle\Helper\CoreHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eZ\Publish\Core\MVC\Symfony\View\View;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /** @var  CoreHelper */
    protected $coreHelper;

    /* Homepage
    * @param View $view
    * @return View
    */
    public function indexAction(View $view)
    {
        $this->coreHelper = $this->container->get('app.core_helper');
        $response = new Response();
        $response->headers->set('X-Location-Id', $view->getLocation()->id);
        $response->setPublic();
        $response->setSharedMaxAge($this->container->getParameter('app.cache.high.ttl'));
        $view->setResponse($response);

        $view->addParameters([
            'galleryLocationId' => $this->container->getParameter('app.gallery.locationid'),
            'rootLocationId' => $this->get('ezpublish.config.resolver')->getParameter('content.tree_root.location_id')
        ]);

        return $view;
    }
}
