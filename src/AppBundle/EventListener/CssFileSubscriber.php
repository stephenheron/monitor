<?php

namespace AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use AppBundle\Entity\CssFile;
use AppBundle\Manager\QueueManager;

class CssFileSubscriber implements EventSubscriber
{

    /**
     * @var QueueManager
     */
    private $queueManager;

    function __construct(QueueManager $queueManager)
    {
        $this->queueManager = $queueManager;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postPersist'
        );
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof CssFile) {
            $cssFile = $entity;

            if($cssFile->getStats()) {
                $this->queueManager->createGenerateCssStatsJob($cssFile);
            }

        }
    }

}
