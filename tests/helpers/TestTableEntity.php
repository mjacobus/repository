<?php

namespace Dummy;

use Koine\Repository\Entity\IdAwareEntity;

/**
 * Dummy\TestTableEntity
 */
class TestTableEntity extends IdAwareEntity
{
    private $name;
    private $value;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
