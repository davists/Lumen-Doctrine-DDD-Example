<?php

namespace Domain\Entities;

/**
 * ProductCategory
 */
class ProductCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \Domain\Entities\Category
     */
    private $category;

    /**
     * @var \Domain\Entities\Product
     */
    private $product;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ProductCategory
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set category
     *
     * @param \Domain\Entities\Category $category
     *
     * @return ProductCategory
     */
    public function setCategory(\Domain\Entities\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Domain\Entities\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set product
     *
     * @param \Domain\Entities\Product $product
     *
     * @return ProductCategory
     */
    public function setProduct(\Domain\Entities\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Domain\Entities\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}

