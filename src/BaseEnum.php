<?php namespace PropertyLogic\Chess;

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

abstract class BaseEnum
{
    /**
     * MyEnum constructor.
     * @param $value
     */
    final public function __construct($value)
    {
        $c = new \ReflectionClass($this);
        if (!in_array($value, $c->getConstants())) {
            throw \IllegalArgumentException();
        }
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    final public function __toString()
    {
        return $this->value;
    }
}