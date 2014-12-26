<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CustomerController extends Controller
{
    /**
     * @Route("/register", name="register_customer")
     */
    public function newAction(Request $request)
    {
        if($this->getUser()){
           throw new AccessDeniedException();
        }

        $customer = new Customer();
        $customer->setActive(false);

        $form = $this->createForm(new CustomerType(), $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $customerId = $customer->getId();
            $session = $request->getSession();
            $session->set('new_customer_id', $customerId);

            return $this->redirectToRoute('fos_user_registration_register');
        }

        return $this->render('customer/new.html.twig', ['form' => $form->createView()]);
    }
}
