<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Snapshot;
use AppBundle\Entity\Property;
use AppBundle\Entity\Path;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $snapshot = new Snapshot();

        $em = $this->getDoctrine()->getManager();

        $property = $this->getDoctrine()
            ->getRepository('AppBundle:Property')
            ->find(1);

        $path = $this->getDoctrine()
            ->getRepository('AppBundle:Path')
            ->find(1);
        $path->setProperty($property);
        //$em->persist($path);

        $snapshot->setPath($path);
        $em->persist($snapshot);

        $em->flush();

        return $this->render('index.html.twig');
    }
}
