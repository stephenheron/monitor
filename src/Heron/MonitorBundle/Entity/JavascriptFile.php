<?php

namespace Heron\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JavascriptFile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Heron\MonitorBundle\Entity\JavascriptFileRepository")
 */
class JavascriptFile
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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="bigint")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="Snapshot", inversedBy="javascriptFiles")
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
     * Set path
     *
     * @param string $path
     * @return JavascriptFile
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
     * Set content
     *
     * @param string $content
     * @return JavascriptFile
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return JavascriptFile
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set snapshot
     *
     * @param \Heron\MonitorBundle\Entity\Snapshot $snapshot
     * @return JavascriptFile
     */
    public function setSnapshot(\Heron\MonitorBundle\Entity\Snapshot $snapshot = null)
    {
        $this->snapshot = $snapshot;

        return $this;
    }

    /**
     * Get snapshot
     *
     * @return \Heron\MonitorBundle\Entity\Snapshot 
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }
}
