<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specification
 *
 * @ORM\Table(name="specification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecificationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Specification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ram", type="string", length=255, nullable=true)
     */
    private $ram;

    /**
     * @var string|null
     *
     * @ORM\Column(name="storage", type="string", length=255, nullable=true)
     */
    private $storage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="weight", type="string", length=255, nullable=true)
     */
    private $weight;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dimension", type="string", length=255, nullable=true)
     */
    private $dimension;

    /**
     * @var string|null
     *
     * @ORM\Column(name="battery", type="string", length=255, nullable=true)
     */
    private $battery;

    /**
     * @var string|null
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ram.
     *
     * @param string|null $ram
     *
     * @return Specification
     */
    public function setRam($ram = null)
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * Get ram.
     *
     * @return string|null
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * Set storage.
     *
     * @param string|null $storage
     *
     * @return Specification
     */
    public function setStorage($storage = null)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get storage.
     *
     * @return string|null
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set weight.
     *
     * @param string|null $weight
     *
     * @return Specification
     */
    public function setWeight($weight = null)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return string|null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set dimension.
     *
     * @param string|null $dimension
     *
     * @return Specification
     */
    public function setDimension($dimension = null)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension.
     *
     * @return string|null
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set battery.
     *
     * @param string|null $battery
     *
     * @return Specification
     */
    public function setBattery($battery = null)
    {
        $this->battery = $battery;

        return $this;
    }

    /**
     * Get battery.
     *
     * @return string|null
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * Set color.
     *
     * @param string|null $color
     *
     * @return Specification
     */
    public function setColor($color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string|null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Specification
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Specification
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Model", inversedBy="specification")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    private $model;

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setTimeStamp()
    {  
        $this->updatedAt = new \DateTime('now');
       
        if($this->createdAt == null){
            $this->createdAt = new \DateTime('now');
        }
    }

}
