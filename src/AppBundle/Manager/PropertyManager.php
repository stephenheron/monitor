<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class PropertyManager {

    private $propertyRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->propertyRepository = $entityManager->getRepository('AppBundle:Property');
    }

    public function getPropertiesForUser(User $user)
    {
        $customer = $user->getCustomer();
        $properties = $this->propertyRepository->getPropertiesForCustomer($customer);

        return $properties;
    }

    public function getPropertiesWithPathsForUser(User $user)
    {
        $customer = $user->getCustomer();
        $properties = $this->propertyRepository->getPropertiesWithPathsForCustomer($customer);

        return $properties;
    }

}
