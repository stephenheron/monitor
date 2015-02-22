<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Snapshot;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SnapshotController extends Controller
{

    /**
     * @Route("/snapshot/{id}", name="show_snapshot")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Snapshot $snapshot, Request $request) {
        $user = $this->getUser();
        $userManager = $this->get('user_manager');

        if($userManager->allowedAccessToProperty($user, $snapshot->getPath()->getProperty())) {
            $image = $snapshot->getPreferredImage();
            $har = $snapshot->getHarObject();

            $viewVars  = [];
            $viewVars['snapshot'] = $snapshot;
            $viewVars['image_data'] = $image->getImageData();
            $viewVars['request_data'] = $this->getRequestDataCollection($har);
            $viewVars['main_html_request'] = $har->getMainRequest();

            return $this->render('snapshot/show.html.twig', $viewVars);
        } else {
            throw new AccessDeniedException;
        }
    }

    private function getRequestDataCollection($har)
    {

        $requestSizes = [
            'All' => $har->getAllRequestsSize() + ['requests' => $har->getAllRequests()],
            'HTML' => $har->getHtmlRequestsSize() + ['requests' => $har->getHtmlRequests()],
            'CSS' => $har->getCSSRequestsSize() + ['requests' => $har->getCSSRequests()],
            'Javascript' => $har->getJSRequestsSize() + ['requests' => $har->getJSRequests()],
            'Images' => $har->getImageRequestsSize() + ['requests' => $har->getImageRequests()],
            'Other' => $har->getOtherRequestsSize() + ['requests' => $har->getOtherRequests()],
        ];

        return $requestSizes;
    }

}
