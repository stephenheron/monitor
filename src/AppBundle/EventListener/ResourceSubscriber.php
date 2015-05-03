<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\JavascriptFile;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use AppBundle\Entity\CssFile;
use AppBundle\Manager\QueueManager;

class ResourceSubscriber implements EventSubscriber
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

            if(!$cssFile->getStats() && $cssFile->getUrl()) {
                $this->queueManager->createGenerateCssStatsJob($cssFile);
            }

            if($cssFile->getUrl()) {
                $this->queueManager->createRequestCssJob($cssFile);
            }
        }

        if($entity instanceof JavascriptFile) {
            $jsFile = $entity;

            if($jsFile->getUrl()) {
                $this->queueManager->createRequestJsJob($jsFile);
            }
        }
    }

}
