<?php

namespace AppBundle\Model;

class Har
{
    private $harSource;

    private $entries;

    private $processedEntries = [
        'HTML'      => null,
        'CSS'       => null,
        'JS'        => null,
        'IMAGES'    => null,
        'VIDEOS'    => null,
        'OTHER'     => null
    ];

    private $mainRequest;

    private $mineTypes =[
        'HTML' =>   ['text/html'],
        'JS' =>     ['application/x-javascript', 'application/javascript', 'application/ecmascript', 'text/javascript', 'text/ecmascript'],
        'CSS' =>    ['text/css'],
        'IMAGES' => ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/svg+xml'],
        'VIDEOS' => ['video/avi', 'video/mpeg', 'video/mp4', 'video/ogg', 'video/quicktime', 'video/webm', 'video/x-matroska', 'video/x-ms-wmv', 'video/x-flv']
    ];

    function __construct($harSource)
    {
        $this->harSource = $harSource;
        $rawHarArray = json_decode($harSource, true);

        if($rawHarArray){
            $this->entries = $rawHarArray['log']['entries'];

        } else {
            throw new \Exception('HAR does not appear to be JSON');
        }
    }

    /*
     * We are assuming the first entry is the main page that was requested
     */
    public function getMainRequest()
    {
        if($this->mainRequest){
            return $this->mainRequest;
        }

        $firstRequest = reset($this->entries);
        $this->mainRequest = $this->processEntry($firstRequest);

        return $this->mainRequest;
    }

    public function getAllRequests()
    {
        $requests = array_merge($this->getHtmlRequests(),
            $this->getCSSRequests(),
            $this->getJSRequests(),
            $this->getImageRequests(),
            $this->getVideoRequests(),
            $this->getOtherRequests());

        return $requests;
    }

    public function getAllRequestsSize()
    {
        $totalSizes = ['size' => 0, 'compressed_size' => 0];
        $requestSizes = [
            $this->getHtmlRequestsSize(),
            $this->getCSSRequestsSize(),
            $this->getJSRequestsSize(),
            $this->getOtherRequestsSize(),
            $this->getImageRequestsSize()
        ];

        foreach($requestSizes as $sizes){
            $totalSizes['size'] += $sizes['size'];
            $totalSizes['compressed_size'] += $sizes['compressed_size'];
        }

        return $totalSizes;
    }

    public function getHtmlRequests()
    {
        return $this->getRequests('HTML');
    }

    public function getHtmlRequestsSize()
    {
        $requests = $this->getHtmlRequests();
        return $this->getResponseSize($requests);
    }

    public function getCSSRequests()
    {
        return $this->getRequests('CSS');
    }

    public function getCSSRequestsSize()
    {
        $requests = $this->getCSSRequests();
        return $this->getResponseSize($requests);
    }

    public function getJSRequests()
    {
        return $this->getRequests('JS');
    }

    public function getJSRequestsSize()
    {
        $requests = $this->getJSRequests();
        return $this->getResponseSize($requests);
    }

    public function getImageRequests()
    {
        return $this->getRequests('IMAGES');
    }

    public function getImageRequestsSize()
    {
        $requests = $this->getImageRequests();
        return $this->getResponseSize($requests);
    }

    public function getVideoRequests()
    {
        return $this->getRequests('VIDEOS');
    }

    public function getVideoRequestsSize()
    {
        $requests = $this->getVideoRequests();
        return $this->getResponseSize($requests);
    }

    public function getOtherRequests()
    {
        return $this->getRequests('OTHER');
    }

    public function getOtherRequestsSize()
    {
        $requests = $this->getOtherRequests();
        return $this->getResponseSize($requests);
    }

    private function getRequests($type)
    {
        //Return the cached version
        if(($this->processedEntries[$type]) !== null) {
            return $this->processedEntries[$type];
        }

        //Create arrays for each of the types
        foreach($this->processedEntries as $bucketName => $container) {
            $this->processedEntries[$bucketName] = [];
        }

        //Sort the entries into buckets
        foreach($this->entries as $entry) {
            $processedEntry = $this->processEntry($entry);
            $requestMimeType = $processedEntry['mime_type'];
            $found = false;
            foreach($this->mineTypes as $key => $types) {
                foreach($types as $mimeType) {
                    if(strpos($requestMimeType, $mimeType) !== false) {
                        array_push($this->processedEntries[$key], $processedEntry);
                        $found = true;
                        break 2;
                    }
                }
            }

            if($found == false) {
                array_push($this->processedEntries['OTHER'], $processedEntry);
            }
        }

        return $this->processedEntries[$type];

    }

    public function getHarSource()
    {
        return $this->harSource;
    }

    private function processEntry($entry)
    {
        $processedEntry = [];

        $processedEntry['url'] = $entry['request']['url'];
        $processedEntry['response_cookies'] = $entry['request']['cookies'];
        $processedEntry['response_code'] = $entry['response']['status'];
        $processedEntry['response_headers'] = $entry['response']['headers'];
        $processedEntry['size'] = $entry['response']['content']['size'];

        if(isset($entry['response']['content']['compression'])) {
            $processedEntry['compressed_size'] = $entry['response']['content']['compression'];
        } else {
            $processedEntry['compressed_size'] = $processedEntry['size'];
        }

        $processedEntry['mime_type'] = $entry['response']['content']['mimeType'];

        return $processedEntry;
    }

    private function getResponseSize($requests)
    {
        $size = 0;
        $compressedSize = 0;

        foreach($requests as $request) {
            $size += $request['size'];
            $compressedSize += $request['compressed_size'];
        }

        return [
            'size'            => $size,
            'compressed_size' => $compressedSize
        ];
    }


}