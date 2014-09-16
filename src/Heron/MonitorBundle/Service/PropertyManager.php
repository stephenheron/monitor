<?php

namespace Heron\MonitorBundle\Service;

use Heron\MonitorBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class PropertyManager {

    private $propertyRepoistory;

    public function __construct(EntityManager $entityManager)
    {
        $this->propertyRepository = $entityManager->getRepository('HeronMonitorBundle:Property');
    }

    public function getPropertiesForUser(User $user)
    {
        $customer = $user->getCustomer();
        $properties = $this->propertyRepository->getPropertiesForCustomer($customer);

        return $properties;
    }

}
