<?php

namespace AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use AppBundle\Entity\Snapshot;
use AppBundle\Manager\QueueManager;

class SnapshotSubscriber implements EventSubscriber
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

      if($entity instanceof Snapshot) {
         $snapshot = $entity;

         if($snapshot->getHar() == null) {
            $this->queueManager->createGenerateHarJob($snapshot);
         }

         if($snapshot->getMirrorDirectoryName() == null) {
            $this->queueManager->createGenerateMirrorJob($snapshot);
         }

         if(count($snapshot->getImages()) === 0) {
            $this->queueManager->createGenerateImagesJob($snapshot);
         }

         if($snapshot->getHtmlSource() == null) {
            $this->queueManager->createRequestHtmlJob($snapshot);
         }
      }
   }

}
