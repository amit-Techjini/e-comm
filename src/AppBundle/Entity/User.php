<?php

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

use AppBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profile_pic", type="string", length=255, nullable=true)
     */
    private $profilePic;

    /**
     * @var string
     *
     * @ORM\Column(name="user_type", type="string", length=255)
     */
    private $userType;
   
    /**
     * @var int
     *
     * @ORM\Column(name="phone_no", type="integer", nullable=true)
     */
    private $phoneNo;

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
     * @param string|null $name
     *
     * @return User
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set profilePic.
     *
     * @param string|null $profilePic
     *
     * @return User
     */
    public function setProfilePic($profilePic = null)
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    /**
     * Get profilePic.
     *
     * @return string|null
     */
    public function getProfilePic()
    {
        return $this->profilePic;
    }

    /**
     * Set userType.
     *
     * @param string $userType
     *
     * @return User
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType.
     *
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set phoneNo.
     *
     * @param int|null $phoneNo
     *
     * @return User
     */
    public function setPhoneNo($phoneNo)
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    /**
     * Get phoneNo.
     *
     * @return int|null
     */
    public function getPhoneNo()
    {
        return $this->phoneNo;
    }
    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * @return User
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


    //interface function
    public function getUsername()
    {
        return $this->email;
    }


    //salt function
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {   if($this->userType == UserRepository::CUSTOMER)
            return array('ROLE_CUSTOMER');
        
        if($this->userType ==  UserRepository::SELLER)
            return array('ROLE_SELLER');
        
        if($this->userType ==  UserRepository::ADMIN)
            return array('ROLE_ADMIN');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, array('allowed_classes' => false));
    }
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Address", mappedBy="user")
     */
    private $address;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SellerProduct", mappedBy="user")
     */
    private $sellerProduct;
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Cart", mappedBy="user")
     */
    private $cart;

    public function __construct()
    {
        $this->sellerProduct = new ArrayCollection();
        $this->address = new ArrayCollection();
        $this->cart = new ArrayCollection();
    }


    function setSellerProduct(?SellerProduct $sellerProduct):self
    {
         $this->sellerProduct = $sellerProduct;
         return $this;
    }

    /**
     * @return ArrayCollection|SellerProduct[]
     */
    public function getSellerProduct()
    {
        return $this->sellerProduct;
    }



    function setAddress(?Address $address):self
    {
         $this->address = $address;
         return $this;
    }
    /**
     * @return ArrayCollection|Address[]
     */
    public function getAddress()
    {
        return $this->address;
    }

//getter and setter for cart
    function setCart(?Cart $cart):self
    {
         $this->cart = $cart;
         return $this;
    }

    /**
     * @return ArrayCollection|Cart[]
     */
    public function getCart()
    {
        return $this->cart;
    }
}
