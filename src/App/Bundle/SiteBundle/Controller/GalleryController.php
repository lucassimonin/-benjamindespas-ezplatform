<?php

namespace App\Bundle\SiteBundle\Controller;

use App\Bundle\SiteBundle\Helper\CoreHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
    /** @var  CoreHelper */
    protected $coreHelper;

    public function indexAction(Request $request, $locationId, $viewType, $layout = false, array $params = array())
    {
        $this->coreHelper = $this->container->get('app.core_helper');

        $params['galleryLocationId'] = $this->container->getParameter('app.gallery.locationid');
        $params['rootLocationId'] = $this->get('ezpublish.config.resolver')->getParameter('content.tree_root.location_id');
        //$params['gallery_items'] = $this->coreHelper->getChildrenObject([$galleryItemContentTypeIdentifier], $galleryLocationId);
        $response = $this->get('ez_content')->viewLocation(
            $locationId,
            $viewType,
            $layout,
            $params
        );

        return $response;
    }

    public function showAction(Request $request, $id)
    {
        $this->coreHelper = $this->container->get('app.core_helper');

        $params['galleryLocationId'] = $this->container->getParameter('app.gallery.locationid');
        $params['gallery'] = $this->coreHelper->getContentByLocationId($params['galleryLocationId']);

        switch($id) {
            case 0:
                $params['title_txt'] = 'peinture';
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
