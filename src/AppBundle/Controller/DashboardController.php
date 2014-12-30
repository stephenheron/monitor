<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Snapshot;
use AppBundle\Entity\Property;
use AppBundle\Entity\Path;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $propertyManager = $this->get('property_manager');
        $properties = $propertyManager->getPropertiesWithPathsForUser($user);

        return $this->render('dashboard.html.twig', ['properties' => $properties]);
    }
}
