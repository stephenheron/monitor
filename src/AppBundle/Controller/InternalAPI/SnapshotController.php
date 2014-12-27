<?php

namespace AppBundle\Controller\InternalAPI;

use AppBundle\Entity\Snapshot;
use AppBundle\Form\ApiSnapshotType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SnapshotController extends FOSRestController
{
    public function patchSnapshotAction($id, Request $request)
    {
        $snapshot = $this->getDoctrine()
            ->getRepository('AppBundle:Snapshot')
            ->find($id);

        if(!$snapshot) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(new ApiSnapshotType(), $snapshot, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($snapshot);
            $em->flush();
            $view = $this->view(['snapshot' => $snapshot]);
        } else {
            $view = $this->view(['form' => $form]);
        }

        return $this->handleView($view);
    }
}
