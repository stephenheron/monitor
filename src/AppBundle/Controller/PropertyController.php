<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use AppBundle\Form\PropertyType;
use AppBundle\Form\EditPropertyType;
use AppBundle\Form\DeletePropertyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;

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

            $this->addFlash('success', 'Property has been created');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('property/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/property/{id}/edit", name="edit_property")
     * @Method({"GET", "POST"})
     * @Security("is_granted('EDIT', property)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Property $property, Request $request) {
        $form = $this->createForm(new EditPropertyType(), $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();

            $this->addFlash('success', 'Property has been updated');
            return $this->redirectToRoute('show_property', ['id' => $property->getId()]);
        }

        $viewVars = ['form' => $form->createView(), 'property' => $property];
        return $this->render('property/edit.html.twig', $viewVars);
    }

    /**
     * @Route("/property/{id}", name="show_property")
     * @Method({"GET"})
     * @Security("is_granted('VIEW', property)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Property $property, Request $request) {
        $formOptions = ['action' => $this->generateUrl('delete_property', ['id' => $property->getId()])];
        $deleteForm = $this->createForm(new DeletePropertyType(), null, $formOptions);

        $viewVars = ['property' => $property, 'delete_form' => $deleteForm->createView()];

        return $this->render('property/show.html.twig', $viewVars);
    }

    /**
     * @Route("/property/{id}", name="delete_property")
     * @Method({"DELETE"})
     * @Security("is_granted('DELETE', property)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Property $property, Request $request)
    {
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
    }

}
