<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Snapshot
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Heron\MoniAppBundle\pshotRepository")
 */
class Snapshot
{
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
     * @ORM\Column(name="htmlSource", type="text")
     */
    private $htmlSource;

    /**
     * @var string
     *
     * @ORM\Column(name="har", type="text")
     */
    private $har;

    /**
     * @ORM\ManyToOne(targetEntity="Path", inversedBy="snapshots")
     * @ORM\JoinColumn(name="path_id", referencedColumnName="id")
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
}