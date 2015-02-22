<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Path;
use AppBundle\Entity\Property;
use AppBundle\Form\PathType;
use AppBundle\Form\EditPathType;
use AppBundle\Form\DeletePathType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PathController extends Controller {

    /**
     * @Route("/property/{id}/path/new", name="new_path")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Property $property, Request $request) {
        $path = new Path();
        $path->setProperty($property);

        $form = $this->createForm(new PathType(), $path);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($path);
            $em->flush();

            $this->addFlash('success', 'Property has been created');
            return $this->redirectToRoute('show_property', ['id' => $property->getId()]);
        }

        return $this->render('path/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/path/{id}/edit", name="edit_path")
     * @Method({"GET", "POST"})
     * @Security("is_granted('EDIT', path)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Path $path, Request $request) {
        $form = $this->createForm(new EditPathType(), $path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($path);
            $em->flush();

            $this->addFlash('success', 'Property has been updated');
            return $this->redirectToRoute('show_path', ['id' => $path->getId()]);
        }

        return $this->render('path/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/path/{id}", name="show_path")
     * @Method({"GET"})
     * @Security("is_granted('VIEW', path)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Path $path, Request $request) {
        $formOptions = ['action' => $this->generateUrl('delete_path', ['id' => $path->getId()])];
        $deleteForm = $this->createForm(new DeletePathType(), null, $formOptions);

        $snapshotRepository = $this->getDoctrine()->getRepository('AppBundle:Snapshot');
        $snapshots = $snapshotRepository->getSnapshotsForPath($path);

        $viewVars = ['path' => $path, 'snapshots' => $snapshots, 'delete_form' => $deleteForm->createView()];
        return $this->render('path/show.html.twig', $viewVars);
    }

    /**
     * @Route("/path/{id}", name="delete_path")
     * @Method({"DELETE"})
     * @Security("is_granted('DELETE', path)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Path $path, Request $request)
    {
        $deleteForm = $this->createForm(new DeletePathType());

        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($path);
            $em->flush();
            $this->addFlash('success', 'Path deleted');
        } else {
            $this->addFlash('error', 'Something went wrong when attempting to delete the path.');
        }
        return $this->redirectToRoute('dashboard');
    }
}