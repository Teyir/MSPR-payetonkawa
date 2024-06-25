<?php

namespace WEB\Entity\Orders;

class OrderEntity
{
    private int $id;
    private int $amount;
    private int $price;
    private int $product_id;
    private int $user_id;
    private string $address;

    /**
     * @param int $id
     * @param int $amount
     * @param int $price
     * @param int $product_id
     * @param int $user_id
     * @param string $address
     */
    public function __construct(int $id, int $amount, int $price, int $product_id, int $user_id, string $address)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->price = $price;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param array $res
     * @return OrderEntity
     */
    public static function map(array $res): OrderEntity
    {
        return new self(
            $res['id'],
            $res['amount'],
            $res['price'],
            $res['product_id'],
            $res['user_id'],
            $res['address'],
        );
    }
}