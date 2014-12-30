<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use AppBundle\Form\PropertyType;
use AppBundle\Form\EditPropertyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Property $property, Request $request) {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $property)) {

            //Delete Form
            $deleteForm = $this->createFormBuilder($property, ['validation_groups' => false])
                ->add('delete', 'submit', ['button_class' => 'danger'])
                ->getForm();

            $deleteForm->handleRequest($request);

            if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($property);
                $em->flush();

                $this->addFlash('info', 'Property deleted');
                return $this->redirectToRoute('dashboard');
            }

            $viewVars = ['property' => $property, 'delete_form' => $deleteForm->createView()];

            return $this->render('property/show.html.twig', $viewVars);
        } else {
            throw new AccessDeniedException();
        }
    }

}
