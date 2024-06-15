<?php

namespace WEB\Manager\Events;

use WEB\Manager\Package\GlobalObject;

abstract class AbstractEvent extends GlobalObject
{

    private static bool $continuePropagation;


    public function init(): void
    {
        static::$continuePropagation = true;
    }


    abstract public function getName(): string;

    public function canPropagate(): bool
    {
        return static::$continuePropagation;
    }

    public function stopPropagation(): void
    {
        static::$continuePropagation = false;
    }


}