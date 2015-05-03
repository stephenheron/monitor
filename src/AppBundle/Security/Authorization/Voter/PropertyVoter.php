<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use AppBundle\Manager\UserManager;

class PropertyVoter extends AbstractEntityVoter
{
    protected $supportedClass = 'AppBundle\Entity\Property';

    public function vote(TokenInterface $token, $property, array $attributes)
    {
        $response = $this->preVote($token, $property, $attributes);
        if($response !== null) {
            return $response;
        }

        $user = $token->getUser();
        if($property && $this->userManager->allowedAccessToProperty($user, $property)) {
            return VoterInterface::ACCESS_GRANTED;
        } else {
            return VoterInterface::ACCESS_DENIED;
        }
    }

}
