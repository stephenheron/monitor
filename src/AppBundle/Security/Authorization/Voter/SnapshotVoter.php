<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use AppBundle\Manager\UserManager;

class SnapshotVoter extends AbstractEntityVoter
{

    protected $supportedClass = 'AppBundle\Entity\Snapshot';

    public function vote(TokenInterface $token, $snapshot, array $attributes)
    {
        $response = $this->preVote($token, $snapshot, $attributes);
        if($response !== null) {
            return $response;
        }

        $user = $token->getUser();
        $property = $snapshot->getPath()->getProperty();
        if($property && $this->userManager->allowedAccessToProperty($user, $property)) {
            return VoterInterface::ACCESS_GRANTED;
        } else {
            return VoterInterface::ACCESS_DENIED;
        }
    }

}
