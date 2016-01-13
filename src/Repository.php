<?php

namespace Koine\Repository;

class Repository extends RepositoryAbstract
{
    public function persist($entity)
    {
        throw new \Exception('Method ' . __METHOD__ . ' was not implemented');
    }

    public function remove($entity)
    {
        throw new \Exception('Method ' . __METHOD__ . ' was not implemented');
    }
}
