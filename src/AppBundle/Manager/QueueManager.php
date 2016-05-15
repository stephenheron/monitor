<?php

namespace AppBundle\Manager;

use AppBundle\Entity\JavascriptFile;
use AppBundle\Entity\Snapshot;
use AppBundle\Entity\CssFile;
use AppBundle\Entity\SnapshotImage;
use \GearmanClient;

class QueueManager
{
    /**
     * @var GearmanClient
     */
    private $gearmanClient;

    /**
     * @var string
     */
    private $mirrorDirectory;

    function __construct($host, $port, $mirrorDirectory)
    {
        $gearmanClient = new GearmanClient();
        $gearmanClient->addServer($host, $port);
        $this->gearmanClient = $gearmanClient;

        $this->mirrorDirectory = $mirrorDirectory;

        //TODO: REMOVE THIS LINE, forcing to /tmp because of bloody vagrant
        $this->mirrorDirectory = '/tmp';
    }

    public function createGenerateHarJob(Snapshot $snapshot)
    {
        $jobData = array(
            'snapshotID' => $snapshot->getId(),
            'address'    => $snapshot->getUrl()
        );
        $this->addJobToQueue('generateHAR', $jobData);
    }

    public function createGenerateMirrorJob(Snapshot $snapshot)
    {
        $jobData = array(
            'snapshotID' => $snapshot->getId(),
            'address'    => $snapshot->getUrl(),
            'outputDir'  => $this->mirrorDirectory
        );

        $this->addJobToQueue('generateMirror', $jobData);
    }

    public function createGenerateImagesJob(Snapshot $snapshot)
    {
        foreach(SnapshotImage::$imageSizes as $imageSize) {
            $jobData = array(
                'snapshotID' => $snapshot->getId(),
                'address'    => $snapshot->getUrl(),
                'height'     => $imageSize['height'],
                'width'      => $imageSize['width']
            );
            $this->addJobToQueue('generateScreenshot', $jobData);
        }

    }

    public function createRequestJsJob(JavascriptFile $jsFile)
    {
        $jobData = array(
            'resourceID' => $jsFile->getId(),
            'address'    => $jsFile->getUrl(),
            'type'      => 'js'
        );
        $this->addJobToQueue('requestResource', $jobData);
    }

    public function createRequestCssJob(CssFile $cssFile)
    {
        $jobData = array(
            'resourceID' => $cssFile->getId(),
            'address'    => $cssFile->getUrl(),
            'type'      => 'css'
        );
        $this->addJobToQueue('requestResource', $jobData);
    }


    public function createRequestHtmlJob(Snapshot $snapshot)
    {
        $jobData = array(
            'resourceID' => $snapshot->getId(),
            'address'    => $snapshot->getUrl(),
            'type'      => 'html'
        );
        $this->addJobToQueue('requestResource', $jobData);
    }

    public function createGenerateCssStatsJob(CssFile $cssFile)
    {
        //TODO: Might want to fetch for DB rather than from the site again?
        $jobData = array(
            'cssFileID' => $cssFile->getId(),
            'address'   => $cssFile->getUrl()
        );
        $this->addJobToQueue('generateCssStats', $jobData);
    }

    private function addJobToQueue($name, $payload)
    {
        $payload = json_encode($payload);
        $handle = $this->gearmanClient->doBackground($name, $payload);
        if($this->gearmanClient->returnCode() != GEARMAN_SUCCESS) {
            throw new \Exception('Gearmean return code was not success it was instead ' . $this->gearmanClient->returnCode());
        }
    }
}
