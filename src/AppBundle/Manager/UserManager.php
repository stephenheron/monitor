<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Property;
use AppBundle\Entity\User;
use AppBundle\Manager\PropertyManager;

class UserManager
{
    private $propertyManager;

    function __construct(PropertyManager $propertyManager)
    {
        $this->propertyManager = $propertyManager;
    }

    public function allowedAccessToProperty(User $user, Property $propertyAttemptingToAccess)
    {
        $properties = $this->propertyManager->getPropertiesForUser($user);

        $allowed = false;
        foreach($properties as $property) {
            if($property->getId() == $propertyAttemptingToAccess->getId()) {
                $allowed = true;
                break;
            }
        }

        return $allowed;
    }

}
