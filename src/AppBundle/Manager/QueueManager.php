<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Snapshot;
use AppBundle\Entity\CssFile;
use \GearmanClient;
use Symfony\Component\Config\Definition\Exception\Exception;

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
        //TODO: we might want to generate a couple of different resolutions
        $defaultHeight = 1920;
        $defaultWidth = 1080;

        $jobData = array(
            'snapshotID' => $snapshot->getId(),
            'address'    => $snapshot->getUrl(),
            'height'     => $defaultHeight,
            'width'      => $defaultWidth
        );
        $this->addJobToQueue('generateScreenshot', $jobData);
    }

    //TODO: Not used yet, add to the API request
    public function createRequestHtmlCssJobs(Snapshot $snapshot)
    {
        //TODO: Need to process the HAR for this one, leave it until we have an actual HAR to process
        dump($snapshot);
    }


    public function createRequestHtmlJob(Snapshot $snapshot)
    {
        $jobData = array(
            'snapshotID' => $snapshot->getId(),
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
            throw new Exception('Gearmean return code was not success it was instead ' . $this->gearmanClient->returnCode());
        }
    }
}
