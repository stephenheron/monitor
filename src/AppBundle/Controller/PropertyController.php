<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use AppBundle\Form\PropertyType;
use AppBundle\Form\EditPropertyType;
use AppBundle\Form\DeletePropertyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PropertyController extends Controller
{
    /**
     * @Route("/property/new", name="new_property")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request) {
        $user = $this->getUser();

        $property = new Property();
        $property->setCustomer($user->getCustomer());

        $form = $this->createForm(new PropertyType(), $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();

            $this->addFlash('info', 'Property has been created');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('property/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/property/{id}/edit", name="edit_property")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Property $property, Request $request) {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $property)) {
            $form = $this->createForm(new EditPropertyType(), $property);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($property);
                $em->flush();

                $this->addFlash('info', 'Property has been updated');
                return $this->redirectToRoute('show_property', ['id' => $property->getId()]);
            }

            $viewVars = ['form' => $form->createView(), 'property' => $property];
            return $this->render('property/edit.html.twig', $viewVars);
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * @Route("/property/{id}", name="show_property")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Property $property, Request $request) {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $property)) {
            $formOptions = ['action' => $this->generateUrl('delete_property', ['id' => $property->getId()])];
            $deleteForm = $this->createForm(new DeletePropertyType(), null, $formOptions);

            $viewVars = ['property' => $property, 'delete_form' => $deleteForm->createView()];

            return $this->render('property/show.html.twig', $viewVars);
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * @Route("/property/{id}", name="delete_property")
     * @Method({"DELETE"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Property $property, Request $request)
    {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $property)) {
            $deleteForm = $this->createForm(new DeletePropertyType());

            $deleteForm->handleRequest($request);

            if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($property);
                $em->flush();

                $this->addFlash('success', 'Property deleted');
            } else {
                $this->addFlash('error', 'Something went wrong when attempting to delete the property.');
            }
            return $this->redirectToRoute('dashboard');
        } else {
            throw new AccessDeniedException;
        }
    }

}
