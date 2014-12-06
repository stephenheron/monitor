<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 08/11/2014
 * Time: 16:11
 */

namespace AppBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as FOSRegistrationFormHandler;
use AppBundle\Manager\CustomerManager;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistrationFormHandler extends FOSRegistrationFormHandler {

    protected $customerManager;

    public function __construct(FormInterface $form, Request $request, UserManagerInterface $userManager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, CustomerManager $customerManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->userManager = $userManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->customerManager = $customerManager;
    }

    protected function onSuccess(UserInterface $user, $confirmation) {

        $session = $this->request->getSession();
        $customerId = $session->get('new_customer_id');

        if($customerId) {
            $customer = $this->customerManager->getCustomerById($customerId);
            $session->set('new_customer_id', null);
        } else {
            $customer = $user->getCustomer();
        }

        if($customer) {
            $user->setCustomer($customer);
        }

        parent::onSuccess($user, $confirmation);

        if($customer && $customer->getActivate() == false) {
            $this->customerManager->activateCustomer($customer);
        }
    }


}