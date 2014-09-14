<?php

namespace Heron\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Difference
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Heron\MonitorBundle\Entity\DifferenceRepository")
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
     * @param \Heron\MonitorBundle\Entity\Snapshot $snapshotA
     * @return Difference
     */
    public function setSnapshotA(\Heron\MonitorBundle\Entity\Snapshot $snapshotA = null)
    {
        $this->snapshotA = $snapshotA;

        return $this;
    }

    /**
     * Get snapshotA
     *
     * @return \Heron\MonitorBundle\Entity\Snapshot 
     */
    public function getSnapshotA()
    {
        return $this->snapshotA;
    }

    /**
     * Set snapshotB
     *
     * @param \Heron\MonitorBundle\Entity\Snapshot $snapshotB
     * @return Difference
     */
    public function setSnapshotB(\Heron\MonitorBundle\Entity\Snapshot $snapshotB = null)
    {
        $this->snapshotB = $snapshotB;

        return $this;
    }

    /**
     * Get snapshotB
     *
     * @return \Heron\MonitorBundle\Entity\Snapshot 
     */
    public function getSnapshotB()
    {
        return $this->snapshotB;
    }
}
