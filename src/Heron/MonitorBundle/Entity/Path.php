<?php

namespace Heron\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Path
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Heron\MonitorBundle\Entity\PathRepository")
 */
class Path
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="Property", inversedBy="paths")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    private $property;

    /**
     * @ORM\OneToMany(targetEntity="Snapshot", mappedBy="path")
     **/
    private $snapshots;

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
     * Set path
     *
     * @param string $path
     * @return Path
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Path
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set property
     *
     * @param \Heron\MonitorBundle\Entity\Property $property
     * @return Path
     */
    public function setProperty(\Heron\MonitorBundle\Entity\Property $property = null)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return \Heron\MonitorBundle\Entity\Property 
     */
    public function getProperty()
    {
        return $this->property;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->snapshots = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add snapshots
     *
     * @param \Heron\MonitorBundle\Entity\Snapshot $snapshots
     * @return Path
     */
    public function addSnapshot(\Heron\MonitorBundle\Entity\Snapshot $snapshots)
    {
        $this->snapshots[] = $snapshots;

        return $this;
    }

    /**
     * Remove snapshots
     *
     * @param \Heron\MonitorBundle\Entity\Snapshot $snapshots
     */
    public function removeSnapshot(\Heron\MonitorBundle\Entity\Snapshot $snapshots)
    {
        $this->snapshots->removeElement($snapshots);
    }

    /**
     * Get snapshots
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSnapshots()
    {
        return $this->snapshots;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Path
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
     * @return Path
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
