<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    public function __construct() {
        $this->productCategoryAssociations = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="ProductCategoryAssociation", mappedBy="product")
     */
    private $productCategoryAssociations;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @Assert\IsTrue(message="The price has to be a correct number")
     */
    public function isPriceValid()
    {
        if(!is_numeric($this->price)) return false;

        return true;
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
     * Set name
     *
     * @param string $name
     * @return Product
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

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add productCategoryAssociations
     *
     * @param \AppBundle\Entity\ProductCategoryAssociation $productCategoryAssociations
     * @return Product
     */
    public function addProductCategoryAssociation(\AppBundle\Entity\ProductCategoryAssociation $productCategoryAssociations)
    {
        $this->productCategoryAssociations[] = $productCategoryAssociations;

        return $this;
    }

    /**
     * Remove productCategoryAssociations
     *
     * @param \AppBundle\Entity\ProductCategoryAssociation $productCategoryAssociations
     */
    public function removeProductCategoryAssociation(\AppBundle\Entity\ProductCategoryAssociation $productCategoryAssociations)
    {
        $this->productCategoryAssociations->removeElement($productCategoryAssociations);
    }

    /**
     * Get productCategoryAssociations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductCategoryAssociations()
    {
        return $this->productCategoryAssociations;
    }
}
