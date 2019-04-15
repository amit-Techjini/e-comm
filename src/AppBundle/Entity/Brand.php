<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Brand
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    // /**
    //  * @var int
    //  *
    //  * @ORM\Column(name="sub_category_id", type="integer")
    //  */
    // private $subCategory;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SubCategory", inversedBy="brand")
     * @ORM\JoinColumn(name="sub_category_id", referencedColumnName="id")
     */
    private $subCategory;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Product", mappedBy="brand")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

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
     * Set name.
     *
     * @param string $name
     *
     * @return Brand
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    // /**
    //  * Set subCategory.
    //  *
    //  * @param int $subCategory
    //  *
    //  * @return Brand
    //  */
    // public function setSubCategory($subCategory)
    // {
    //     $this->subCategory = $subCategory;

    //     return $this;
    // }

    // /**
    //  * Get subCategory.
    //  *
    //  * @return int
    //  */
    // public function getSubCategory()
    // {
    //     return $this->subCategory;
    // }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Brand
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
     * @return Brand
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
     * @return mixed
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }
    /**
     * @param mixed $subCategory
     */
    public function setSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;
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

    /**
     * @return ArrayCollection|Product[]
     */
    public function getProduct()
    {
        return $this->brand;
    }


    function setProduct(?Product $product):self
    {
         $this->product = $product;
         return $this;
    }

}
