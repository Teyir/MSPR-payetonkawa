<?php

namespace WEB\Entity\Products;

class ProductEntity
{
    private int $id;
    private string $title;
    private string $description;
    private string $image;
    private float $pricePerKg;
    private float $kgRemaining;
    private string $dateCreated;
    private string $dateUpdated;

    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param string $image
     * @param float $pricePerKg
     * @param float $kgRemaining
     * @param string $dateCreated
     * @param string $dateUpdated
     */
    public function __construct(int $id, string $title, string $description, string $image, float $pricePerKg, float $kgRemaining, string $dateCreated, string $dateUpdated)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->pricePerKg = $pricePerKg;
        $this->kgRemaining = $kgRemaining;
        $this->dateCreated = $dateCreated;
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return float
     */
    public function getPricePerKg(): float
    {
        return $this->pricePerKg;
    }

    /**
     * @return float
     */
    public function getKgRemaining(): float
    {
        return $this->kgRemaining;
    }

    /**
     * @return string
     */
    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    /**
     * @return string
     */
    public function getDateUpdated(): string
    {
        return $this->dateUpdated;
    }

    /**
     * @param array $res
     * @return \WEB\Entity\Products\ProductEntity
     */
    public static function map(array $res): ProductEntity
    {
        return new self(
            $res['id'],
            $res['title'],
            $res['description'],
            $res['image'],
            $res['price_kg'],
            $res['kg_remaining'],
            $res['date_created'],
            $res['date_updated'],
        );
    }
}