<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Snapshot;
use AppBundle\Entity\Path;
use AppBundle\Form\SnapshotType;
use AppBundle\Model\Har;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SnapshotController extends Controller
{

    /**
     * @Route("/snapshot/{id}", name="show_snapshot")
     * @Security("is_granted('VIEW', snapshot)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Snapshot $snapshot, Request $request) {
        $image = $snapshot->getPreferredImage();
        $har = $snapshot->getHarObject();

        $viewVars  = [];
        $viewVars['snapshot'] = $snapshot;

        if($har) {
            $viewVars['request_data'] = $this->getRequestDataCollection($har);
            $viewVars['main_html_request'] = $har->getMainRequest();
        }

        if($image) {
            $viewVars['image'] = $image;
        }

        $template = 'snapshot/show.html.twig';
        if(!$har) {
            $template = 'snapshot/show-processing.html.twig';
        }

        return $this->render($template, $viewVars);
    }

    /**
     * @Route("/path/{id}/new", name="new_snapshot")
     * @Security("is_granted('VIEW', path)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Path $path, Request $request) {

        $snapshot = new Snapshot();
        $snapshot->setPath($path);

        $form = $this->createForm(new SnapshotType(), $snapshot);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($snapshot);
            $em->flush();

            $this->addFlash('success', 'Snapshot has been created and is awaiting processing');
            return $this->redirectToRoute('show_path', ['id' => $path->getId()]);
        }

        return $this->render('snapshot/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/snapshot/{id}/source", name="show_snapshot_source")
     * @Security("is_granted('VIEW', snapshot)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showSourceAction(Snapshot $snapshot, Request $request) {
        $viewVars = [
            'name'      => $snapshot->getUrl(),
            'created'   => $snapshot->getCreated(),
            'content'   => $snapshot->getHtmlSource()
        ];
        return $this->render('resource/show.html.twig', $viewVars);
    }

    private function getRequestDataCollection(Har $har)
    {
        $requestSizes = [
            'All' => $har->getAllRequestsSize() + ['requests' => $har->getAllRequests()],
            'HTML' => $har->getHtmlRequestsSize() + ['requests' => $har->getHtmlRequests()],
            'CSS' => $har->getCSSRequestsSize() + ['requests' => $har->getCSSRequests()],
            'Javascript' => $har->getJSRequestsSize() + ['requests' => $har->getJSRequests()],
            'Images' => $har->getImageRequestsSize() + ['requests' => $har->getImageRequests()],
            'Other' => $har->getOtherRequestsSize() + ['requests' => $har->getOtherRequests()],
        ];

        return $requestSizes;
    }

}
