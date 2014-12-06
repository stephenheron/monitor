<?php

namespace AppBundle\Manager;

use FOS\UserBundle\Model\UserInterface;
use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityManager;

class CustomerManager {

    private $customerRepository;
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->customerRepository = $entityManager->getRepository('AppBundle:Customer');
        $this->entityManager = $entityManager;
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->find($id);
    }


    public function activateCustomer(Customer $customer)
    {
        $customer->setActive(true);
        $this->updateCustomer($customer);
    }

    public function updateCustomer(Customer $customer)
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }
}
