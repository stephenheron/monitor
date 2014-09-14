<?php

namespace Heron\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Snapshot
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Heron\MonitorBundle\Entity\SnapshotRepository")
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
}