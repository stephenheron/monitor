<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Path;
use AppBundle\Entity\Property;
use AppBundle\Form\PathType;
use AppBundle\Form\EditPathType;
use AppBundle\Form\DeletePathType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Path $path, Request $request) {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $path->getProperty())) {
            $form = $this->createForm(new EditPathType(), $path);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($path);
                $em->flush();

                $this->addFlash('success', 'Property has been created');
                return $this->redirectToRoute('show_path', ['id' => $path->getId()]);
            }

            return $this->render('path/edit.html.twig', ['form' => $form->createView()]);
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * @Route("/path/{id}", name="show_path")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Path $path, Request $request) {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $path->getProperty())) {

            $formOptions = ['action' => $this->generateUrl('delete_path', ['id' => $path->getId()])];
            $deleteForm = $this->createForm(new DeletePathType(), null, $formOptions);

            $snapshotRepository = $this->getDoctrine()->getRepository('AppBundle:Snapshot');
            $snapshots = $snapshotRepository->getSnapshotsForPath($path);

            $viewVars = ['path' => $path, 'snapshots' => $snapshots, 'delete_form' => $deleteForm->createView()];
            return $this->render('path/show.html.twig', $viewVars);
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * @Route("/path/{id}", name="delete_path")
     * @Method({"DELETE"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Path $path, Request $request)
    {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $path->getProperty())) {
            $deleteForm = $this->createForm(new DeletePathType());

            $deleteForm->handleRequest($request);

            if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($path);
                $em->flush();
                $this->addFlash('success', 'Path deleted');
            } else {
                $this->addFlash('error', 'Something went wrong when attempting to delete the property.');
            }
            return $this->redirectToRoute('dashboard');
        } else {
            throw new AccessDeniedException;
        }
    }
}