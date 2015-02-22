<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use AppBundle\Manager\UserManager;

class PathVoter extends AbstractEntityVoter
{
    private $userManager;

    protected $supportedClass = 'AppBundle\Entity\Path';

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function vote(TokenInterface $token, $path, array $attributes)
    {
        $response = $this->preVote($token, $path, $attributes);
        if($response !== null) {
            return $response;
        }

        $user = $token->getUser();
        $property = $path->getProperty();
        if($property && $this->userManager->allowedAccessToProperty($user, $property)) {
            return VoterInterface::ACCESS_GRANTED;
        } else {
            return VoterInterface::ACCESS_DENIED;
        }
    }

}
