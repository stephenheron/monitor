<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Entity\CssFile;
use AppBundle\Entity\JavascriptFile;


class ResourceController extends Controller
{
    /**
     * @Route("/resource/css/{id}", name="show_css_resource")
     * @Security("is_granted('VIEW', cssFile)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCssAction(CssFile $cssFile, Request $request) {
        return $this->render('resource/show.html.twig', $this->getViewVars($cssFile));
    }

    /**
     * @Route("/resource/js/{id}", name="show_js_resource")
     * @Security("is_granted('VIEW', javascriptFile)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showJsAction(JavascriptFile $javascriptFile, Request $request) {
        return $this->render('resource/show.html.twig', $this->getViewVars($javascriptFile));
    }

    private function getViewVars($resource) {
        $viewVars = [
            'name'      => $resource->getName(),
            'created'   => $resource->getCreated(),
            'content'   => $resource->getContent()
        ];

        return $viewVars;
    }
}
