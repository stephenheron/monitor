<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\Path;

class PathController extends FOSRestController {

    /**
     * @Route("/path/{id}", name="show_path")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Path $path, Request $request) {
        $userManager = $this->get('user_manager');
        $user = $this->getUser();

        if($userManager->allowedAccessToProperty($user, $path->getProperty())) {

            $snapshotRepository = $this->getDoctrine()->getRepository('AppBundle:Snapshot');
            $snapshots = $snapshotRepository->getSnapshotsForPath($path);

            $viewVars = ['path' => $path, 'snapshots' => $snapshots];
            return $this->render('path/show.html.twig', $viewVars);
        } else {
            throw new AccessDeniedException();
        }
    }
}