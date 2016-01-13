<?php

namespace Koine\Repository\Entity;

interface GeneratedIdInterface
{
    /**
     * @param int $id
     *
     * @return self
     */
    public function setGeneratedId($id);

    /**
     * @return int
     */
    public function getId();
}
