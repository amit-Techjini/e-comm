<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * model
 *
 * @ORM\Table(name="model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\modelRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Model
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    // /**
    //  * @var int
    //  *
    //  * @ORM\Column(name="specification_id", type="integer")
    //  */
    // private $specificationId;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Specification", mappedBy="model")
     */
    private $specification;

    public function __construct()
    {
        $this->specification = new ArrayCollection();
        $this->sellerProduct = new ArrayCollection();
    }
    /**
     * @return ArrayCollection|Specification[]
     */
    public function getSpecification()
    {
        return $this->specification;
    }
    function setSubCategory(?SubCategory $subCategory):self
    {
         $this->subCategory = $subCategory;
         return $this;
    }
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SellerProduct", mappedBy="model")
     */
    private $sellerProduct;

    
    /**
     * @return ArrayCollection|SellerProduct[]
     */
    public function getSellerProduct()
    {
        return $this->sellerProduct;
    }
    function setSellerProduct(?SellerProduct $sellerProduct):self
    {
         $this->sellerProduct = $sellerProduct;
         return $this;
    }
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="model")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
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
     * @return model
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
    //  * Set specificationId.
    //  *
    //  * @param int $specificationId
    //  *
    //  * @return model
    //  */
    // public function setSpecificationId($specificationId)
    // {
    //     $this->specificationId = $specificationId;

    //     return $this;
    // }

    // /**
    //  * Get specificationId.
    //  *
    //  * @return int
    //  */
    // public function getSpecificationId()
    // {
    //     return $this->specificationId;
    // }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return model
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
     * @return model
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

