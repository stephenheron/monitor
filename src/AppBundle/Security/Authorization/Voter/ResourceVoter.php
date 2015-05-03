<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ResourceVoter extends AbstractEntityVoter {

    private $supportedClasses = [
        'AppBundle\Entity\CssFile',
        'AppBundle\Entity\JavascriptFile'
    ];

    public function supportsClass($class)
    {
        $response = false;
        foreach($this->supportedClasses as $supportedClass){
            $response = ($supportedClass === $class || is_subclass_of($class, $supportedClass));
            if($response === true) {
                break;
            }
        }
        return $response;
    }

    public function vote(TokenInterface $token, $resource, array $attributes)
    {
        $response = $this->preVote($token, $resource, $attributes);
        if($response !== null) {
            return $response;
        }

        $user = $token->getUser();
        $property = $resource->getSnapshot()->getPath()->getProperty();
        if($property && $this->userManager->allowedAccessToProperty($user, $property)) {
            return VoterInterface::ACCESS_GRANTED;
        } else {
            return VoterInterface::ACCESS_DENIED;
        }
    }

}

