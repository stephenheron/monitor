<?php

namespace Heron\MonitorBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class PropertiesController extends FOSRestController
{
    public function getPropertiesAction()
    {
        $propertyManager = $this->get('property_manager');

        $data = $propertyManager->getPropertiesForUser($this->getUser());
        $view = $this->view($data);

        return $this->handleView($view);
    }
}
