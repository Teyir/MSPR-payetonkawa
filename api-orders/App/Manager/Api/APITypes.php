<?php

namespace Orders\Manager\Api;

enum APITypes
{
    case CUSTOMERS;
    case ORDERS;
    case PRODUCTS;
    case MAILS;

    public static function fromName(string $name): APITypes
    {
        foreach (self::cases() as $method) {
            if ($name === $method->name) {
                return $method;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum APITypes");
    }
}