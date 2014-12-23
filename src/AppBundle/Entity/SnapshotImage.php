<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SnapshotImage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SnapshotImageRepository")
 */
class SnapshotImage
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
     * @ORM\Column(name="snapshotImage", type="text", nullable=true)
     */
    private $snapshotImage;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="smallint", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="smallint", nullable=true)
     */
    private $height;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Snapshot", inversedBy="images")
     * @ORM\JoinColumn(name="snapshot_id", referencedColumnName="id")
     **/
    private $snapshot;


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
     * Set snapshotImage
     *
     * @param string $snapshotImage
     * @return SnapshotImage
     */
    public function setSnapshotImage($snapshotImage)
    {
        $this->snapshotImage = $snapshotImage;

        return $this;
    }

    /**
     * Get snapshotImage
     *
     * @return string 
     */
    public function getSnapshotImage()
    {
        return $this->snapshotImage;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return SnapshotImage
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
     * @return SnapshotImage
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
     * Set snapshot
     *
     * @param \AppBundle\Entity\Snapshot $snapshot
     * @return SnapshotImage
     */
    public function setSnapshot(\AppBundle\Entity\Snapshot $snapshot = null)
    {
        $this->snapshot = $snapshot;

        return $this;
    }

    /**
     * Get snapshot
     *
     * @return \AppBundle\Entity\Snapshot 
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return SnapshotImage
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return SnapshotImage
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }
}
