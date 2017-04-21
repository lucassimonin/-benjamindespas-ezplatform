<?php

namespace App\Bundle\SiteBundle\Controller;

use App\Bundle\SiteBundle\Helper\CoreHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use eZ\Publish\Core\MVC\Symfony\View\View;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
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

    public function showAction(Request $request, $id)
    {
        $this->coreHelper = $this->container->get('app.core_helper');

        $params['galleryLocationId'] = $this->container->getParameter('app.gallery.locationid');
        $params['gallery'] = $this->coreHelper->getContentByLocationId($params['galleryLocationId']);

        switch($id) {
            case 0:
                $params['title_txt'] = 'photo';
                $params['attribute_txt'] = 'text_photos';
                break;
            case 1:
                $params['title_txt'] = 'dessin';
                $params['attribute_txt'] = 'text_drawings';
                break;
            case 2:
                $params['title_txt'] = 'peinture';
                $params['attribute_txt'] = 'text_paintings';
                break;
        }

        $params['rootLocationId'] = $this->get('ezpublish.config.resolver')->getParameter('content.tree_root.location_id');
        $params['gallery_items'] = $this->coreHelper->getItemsGallery(intval($id));

        $response = new Response();

        return $this->render('AppSiteBundle:content/parts:gallery.html.twig', $params, $response);

    }
}
