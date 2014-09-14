<?php

namespace Heron\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Heron\MonitorBundle\Entity\CustomerRepository")
 */
class Customer
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
     * @ORM\OneToMany(targetEntity="Property", mappedBy="customer")
     **/
    private $properties;

    /**
     * @ORM\OneToOne(targetEntity="Address", inversedBy="customer")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="secondName", type="string", length=255)
     */
    private $secondName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    public function __construct() 
    {
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set secondName
     *
     * @param string $secondName
     * @return Customer
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string 
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Customer
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
     * Set address
     *
     * @param \Heron\MonitorBundle\Entity\Address $address
     * @return Customer
     */
    public function setAddress(\Heron\MonitorBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Heron\MonitorBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add properties
     *
     * @param \Heron\MonitorBundle\Entity\Property $properties
     * @return Customer
     */
    public function addProperty(\Heron\MonitorBundle\Entity\Property $properties)
    {
        $this->properties[] = $properties;

        return $this;
    }

    /**
     * Remove properties
     *
     * @param \Heron\MonitorBundle\Entity\Property $properties
     */
    public function removeProperty(\Heron\MonitorBundle\Entity\Property $properties)
    {
        $this->properties->removeElement($properties);
    }

    /**
     * Get properties
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
