<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Model\Har;

/**
 * Snapshot
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SnapshotRepository")
 * ExclusionPolicy("all")
 */
class Snapshot
{

    const STATUS_COMPLETE = 'Complete';
    const STATUS_INCOMPLETE = 'Incomplete';

    /**
     *  @var Har
     */
    private $harObject;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="htmlSource", type="text", nullable=true)
     */
    private $htmlSource;

    /**
     * @var string
     *
     * @ORM\Column(name="mirrorDirectoryName", type="string", nullable=true)
     */
    private $mirrorDirectoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", nullable=true)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="har", type="text", nullable=true)
     */
    private $har;

    /**
     * @ORM\ManyToOne(targetEntity="Path", inversedBy="snapshots")
     * @ORM\JoinColumn(name="path_id", referencedColumnName="id")
     * @Exclude
     **/
    private $path;

    /**
     * @ORM\OneToMany(targetEntity="CssFile", mappedBy="snapshot")
     **/
    private $cssFiles;
    
    /**
     * @ORM\OneToMany(targetEntity="JavascriptFile", mappedBy="snapshot")
     **/
    private $javascriptFiles;

    /**
     * @ORM\OneToMany(targetEntity="SnapshotImage", mappedBy="snapshot")
     **/
    private $images;

     /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    public function getStatus()
    {
        if(
            $this->getHarObject() &&
            $this->getHtmlSource() &&
            count($this->getCssFiles()) &&
            count($this->getJavascriptFiles())
            && count($this->getImages())
        ) {
            return Snapshot::STATUS_COMPLETE;
        } else {
            return Snapshot::STATUS_INCOMPLETE;
        }
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if($this->getHar()) {
            json_decode($this->getHar());
            if(!(json_last_error() == JSON_ERROR_NONE)){
                $context->buildViolation('The HAR must be valid JSON')
                    ->atPath('har')
                    ->addViolation();
            }
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set htmlSource
     *
     * @param string $htmlSource
     * @return Snapshot
     */
    public function setHtmlSource($htmlSource)
    {
        $this->htmlSource = $htmlSource;

        return $this;
    }

    /**
     * Get htmlSource
     *
     * @return string 
     */
    public function getHtmlSource()
    {
        return $this->htmlSource;
    }

    /**
     * Set har
     *
     * @param string $har
     * @return Snapshot
     */
    public function setHar($har)
    {
        $this->har = $har;

        return $this;
    }

    /**
     * Get har
     *
     * @return string 
     */
    public function getHar()
    {
        return $this->har;
    }

    /**
     * Set path
     *
     * @param \AppBundle\Entity\Path
     * @return Snapshot
     */
    public function setPath(\AppBundle\Entity\Path $path = null)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return \AppBundle\Entity\Path
    */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cssFiles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->javascriptFiles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cssFiles
     *
     * @param \AppBundle\Entity\cssFile $cssFile
     * @return Snapshot
     */
    public function addCssFile(\AppBundle\Entity\cssFile $cssFiles)
    {
        $this->cssFiles[] = $cssFiles;

        return $this;
    }

    /**
     * Remove cssFiles
     *
     * @param \AppBundle\Entity\cssFile $cssFiles
     */
    public function removeCssFile(\AppBundle\Entity\cssFile $cssFiles)
    {
        $this->cssFiles->removeElement($cssFiles);
    }


    /**
     * Get cssFiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCssFiles()
    {
        return $this->cssFiles;
    }

    /**
     * Remove javascriptFiles
     *
     * @param \AppBundle\Entity\javascriptFile $javascriptFiles
     */
    public function removeJavascriptFile(\AppBundle\Entity\javascriptFile $javascriptFiles)
    {
        $this->javascriptFiles->removeElement($javascriptFiles);
    }

    /**
     * Get javascriptFiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJavascriptFiles()
    {
        return $this->javascriptFiles;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Snapshot
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Snapshot
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add javascriptFiles
     *
     * @param \AppBundle\Entity\JavascriptFile $javascriptFiles
     * @return Snapshot
     */
    public function addJavascriptFile(\AppBundle\Entity\JavascriptFile $javascriptFiles)
    {
        $this->javascriptFiles[] = $javascriptFiles;

        return $this;
    }

    /**
     * Add images
     *
     * @param \AppBundle\Entity\SnapshotImage $images
     * @return Snapshot
     */
    public function addImage(\AppBundle\Entity\SnapshotImage $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \AppBundle\Entity\SnapshotImage $images
     */
    public function removeImage(\AppBundle\Entity\SnapshotImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }


    /**
     * Set mirrorDirectoryName
     *
     * @param string $mirrorDirectoryName
     * @return Snapshot
     */
    public function setMirrorDirectoryName($mirrorDirectoryName)
    {
        $this->mirrorDirectoryName = $mirrorDirectoryName;

        return $this;
    }

    /**
     * Get mirrorDirectoryName
     *
     * @return string 
     */
    public function getMirrorDirectoryName()
    {
        return $this->mirrorDirectoryName;
    }

    /**
     * @return Har
     */
    public function getHarObject()
    {
        if(!$this->harObject && $this->getHar()){
           $this->harObject = new Har($this->getHar());
        }

        /*
         * If the HAR source has changed we need to generate a new HAR object
         * This could be integrated into the above IF but this looks cleaner
         */
        if($this->harObject && $this->harObject->getHarSource() !== $this->getHar()) {
           $this->harObject = new Har($this->getHar());
        }

        return $this->harObject;
    }

    public function getUrl()
    {
        return $this->getPath()->getUrl();
    }

    public function getPreferredImage()
    {
        $images = $this->getImages();
        $imageToReturn = null;
        if(count($images)) {
            foreach($images as $image) {
                if($image->getWidth() == 1080 && $image->getHeight() == 1920) {
                   $imageToReturn = $image;
                   break;
                }
            }

            if(!$imageToReturn) {
                $imageToReturn = $images->first();
            }
        }
        return $imageToReturn;
    }

    public function getSourceLinesOfCode()
    {
        if($this->getHtmlSource()) {
            return substr_count( $this->getHtmlSource(), "\n" );
        } else {
            return 0;
        }
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Snapshot
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
}
