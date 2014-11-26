<?php

namespace Heron\MonitorBundle\Manager;

use FOS\UserBundle\Model\UserInterface;
use Heron\MonitorBundle\Entity\Customer;
use Doctrine\ORM\EntityManager;

class CustomerManager {

    private $customerRepository;
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->customerRepository = $entityManager->getRepository('HeronMonitorBundle:Customer');
        $this->entityManager = $entityManager;
    }

    public function createCustomerFromUser(UserInterface $user)
    {
        $emailAddress = $user->getEmail();

        $customer = new Customer();
        $customer->setEmail($emailAddress);
        $customer->addUser($user);
        $customer->setActive(true);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

}
