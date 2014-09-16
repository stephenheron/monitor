<?php

namespace Heron\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Property
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Heron\MonitorBundle\Entity\PropertyRepository")
 *
 * @ExclusionPolicy("all") 
 */
class Property
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="baseUrl", type="string", length=255)
     * @Expose
     */
    private $baseUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="properties")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="Path", mappedBy="property")
     */
    private $paths;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Expose
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Expose
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
     * Set baseUrl
     *
     * @param string $baseUrl
     * @return Property
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Get baseUrl
     *
     * @return string 
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set customer
     *
     * @param \Heron\MonitorBundle\Entity\Customer $customer
     * @return Property
     */
    public function setCustomer(\Heron\MonitorBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Heron\MonitorBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paths = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add paths
     *
     * @param \Heron\MonitorBundle\Entity\Path $paths
     * @return Property
     */
    public function addPath(\Heron\MonitorBundle\Entity\Path $paths)
    {
        $this->paths[] = $paths;

        return $this;
    }

    /**
     * Remove paths
     *
     * @param \Heron\MonitorBundle\Entity\Path $paths
     */
    public function removePath(\Heron\MonitorBundle\Entity\Path $paths)
    {
        $this->paths->removeElement($paths);
    }

    /**
     * Get paths
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Property
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
     * @return Property
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
     * Set name
     *
     * @param string $name
     * @return Property
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
