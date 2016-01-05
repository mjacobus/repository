<?php

namespace Koine\Repository\Entity;

use Koine\Repository\Entity\GeneratedIdInterface;
use Koine\Repository\Entity\IdAwareInterface;

/**
 * Koine\Repository\Entity\IdAwareEntity
 */
abstract class IdAwareEntity implements GeneratedIdInterface, IdAwareInterface
{
    /**
     * @param int
     */
    private $id;

    public function setGeneratedId($id)
    {
        return $this->setId($id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
