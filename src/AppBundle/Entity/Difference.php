<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Difference
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DifferenceRepository")
 */
class Difference
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
     * @ORM\Column(name="htmlDiff", type="text")
     */
    private $htmlDiff;

    /**
     * @var array
     *
     * @ORM\Column(name="cssDiff", type="json_array")
     */
    private $cssDiff;

    /**
     * @var array
     *
     * @ORM\Column(name="javascriptDiff", type="json_array")
     */
    private $javascriptDiff;

    /**
     * @ORM\OneToOne(targetEntity="Snapshot")
     * @ORM\JoinColumn(name="snapshot_a_id", referencedColumnName="id")
     */
    private $snapshotA;
    
    /**
     * @ORM\OneToOne(targetEntity="Snapshot")
     * @ORM\JoinColumn(name="snapshot_b_id", referencedColumnName="id")
     */
    private $snapshotB;

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
     * Set htmlDiff
     *
     * @param string $htmlDiff
     * @return Difference
     */
    public function setHtmlDiff($htmlDiff)
    {
        $this->htmlDiff = $htmlDiff;

        return $this;
    }

    /**
     * Get htmlDiff
     *
     * @return string 
     */
    public function getHtmlDiff()
    {
        return $this->htmlDiff;
    }

    /**
     * Set cssDiff
     *
     * @param array $cssDiff
     * @return Difference
     */
    public function setCssDiff($cssDiff)
    {
        $this->cssDiff = $cssDiff;

        return $this;
    }

    /**
     * Get cssDiff
     *
     * @return array 
     */
    public function getCssDiff()
    {
        return $this->cssDiff;
    }

    /**
     * Set javascriptDiff
     *
     * @param array $javascriptDiff
     * @return Difference
     */
    public function setJavascriptDiff($javascriptDiff)
    {
        $this->javascriptDiff = $javascriptDiff;

        return $this;
    }

    /**
     * Get javascriptDiff
     *
     * @return array 
     */
    public function getJavascriptDiff()
    {
        return $this->javascriptDiff;
    }

    /**
     * Set snapshotA
     *
     * @param \AppBundle\Entity\Snapshot $snapshotA
     * @return Difference
     */
    public function setSnapshotA(\AppBundle\Entity\Snapshot $snapshotA = null)
    {
        $this->snapshotA = $snapshotA;

        return $this;
    }

    /**
     * Get snapshotA
     *
     * @return \AppBundle\Entity\Snapshot
     */
    public function getSnapshotA()
    {
        return $this->snapshotA;
    }

    /**
     * Set snapshotB
     *
     * @param \AppBundle\Entity\Snapshot $snapshotB
     * @return Difference
     */
    public function setSnapshotB(\AppBundle\Entity\Snapshot $snapshotB = null)
    {
        $this->snapshotB = $snapshotB;

        return $this;
    }

    /**
     * Get snapshotB
     *
     * @return \AppBundle\Entity\Snapshot
     */
    public function getSnapshotB()
    {
        return $this->snapshotB;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Difference
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
     * @return Difference
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
