<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Snapshot;
use AppBundle\Entity\CssFile;
use AppBundle\Entity\JavascriptFile;

class SnapshotManager {

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param Snapshot $snapshot
     */
    public function createResourceEntitiesFromHar($snapshot)
    {
        $harObject = $snapshot->getHarObject();

        $cssRequests = $harObject->getCSSRequests();
        $jsRequests = $harObject->getJSRequests();

        foreach($cssRequests as $cssRequest) {
            $cssFile = new CssFile();
            $cssFile->setSize($cssRequest['size']);
            $cssFile->setUrl($cssRequest['url']);
            $cssFile->setSnapshot($snapshot);
            $this->entityManager->persist($cssFile);
        }

        foreach($jsRequests as $jsRequest) {
            $jsFile = new JavascriptFile();
            $jsFile->setSize($jsRequest['size']);
            $jsFile->setUrl($jsRequest['url']);
            $jsFile->setSnapshot($snapshot);
            $this->entityManager->persist($jsFile);
        }

        $this->entityManager->flush();
    }

}
