<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use AppBundle\Helper\UrlHelper;

/**
 * CssFile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CssFileRepository")
 */
class CssFile extends AbstractResource
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
     * @ORM\Column(name="url", type="string", length=2048, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="bigint", nullable=true)
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="Snapshot", inversedBy="cssFiles")
     * @ORM\JoinColumn(name="snapshot_id", referencedColumnName="id")
     **/
    private $snapshot;

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
     * @var string
     *
     * @ORM\Column(name="stats", type="text", nullable=true)
     */
    private $stats;


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
     * Set url
     *
     * @param string $url
     * @return CssFile
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return CssFile
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
     * @return CssFile
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
     * @param \AppBundle\Entity\Snapshot $snapshot
     * @return CssFile
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
     * Set created
     *
     * @param \DateTime $created
     * @return CssFile
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
     * @return CssFile
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
     * Set stats
     *
     * @param string $stats
     * @return CssFile
     */
    public function setStats($stats)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Get stats
     *
     * @return string 
     */
    public function getStats()
    {
        return $this->stats;
    }

    public function getSimplifiedStats()
    {
        $stats = json_decode($this->getStats(), true);
        $elementsToKeep = [
            'rules',
            'selectors',
            'totalUniqueFontSizes',
            'uniqueFontSize',
            'totalUniqueColors',
            'uniqueColor',
            'idSelectors',
            'importantKeywords',
            'mediaQueries'
        ];

        $simplifiedStats = [];
        foreach($stats as $key => $value) {
            if(in_array($key, $elementsToKeep)) {
                $simplifiedStats[$key] = $value;
            }
        }

        return $simplifiedStats;
    }

}
