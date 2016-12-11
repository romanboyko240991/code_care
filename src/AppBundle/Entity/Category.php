<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="ProductCategoryAssociation", mappedBy="category")
     */
    private $productCategoryAssociations;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

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
     * @return Category
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
     * Add productCategoryAssociations
     *
     * @param \AppBundle\Entity\ProductCategoryAssociation $productCategoryAssociations
     * @return Category
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
