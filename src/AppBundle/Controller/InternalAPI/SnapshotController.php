<?php

namespace AppBundle\Controller\InternalAPI;

use AppBundle\Entity\Snapshot;
use AppBundle\Entity\SnapshotImage;
use AppBundle\Form\ApiImageType;
use AppBundle\Form\ApiSnapshotType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class SnapshotController extends FOSRestController
{
    public function patchSnapshotAction(Snapshot $snapshot, Request $request)
    {
        $preBindSnapshotHar = $snapshot->getHar();

        $form = $this->createForm(new ApiSnapshotType(), $snapshot, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $harCreated = false;
            if(!$preBindSnapshotHar && $form->getData()->getHar()){
                $harCreated = true;
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($snapshot);
            $em->flush();

            if($harCreated) {
                $snapshotManager = $this->get('snapshot_manager');
                $snapshotManager->createResourceEntitiesFromHar($snapshot);
            }

            $view = $this->view(['snapshot' => $snapshot]);
        } else {
            $view = $this->view(['form' => $form]);
        }

        return $this->handleView($view);
    }

    public function postSnapshotImageAction(Snapshot $snapshot, Request $request)
    {
        $image = new SnapshotImage();
        $image->setSnapshot($snapshot);

        $imageData = $request->get('imageData');
        $request->request->remove('imageData');
        $image->setImageFileFromBase64Data($imageData);

        $form = $this->createForm(new ApiImageType(), $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            $view = $this->view(['snapshot' => $snapshot]);
        } else {
            $view = $this->view(['form' => $form]);
        }

        return $this->handleView($view);
    }
}
