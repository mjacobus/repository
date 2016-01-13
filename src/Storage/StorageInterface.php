<?php

namespace Koine\Repository\Storage;

use Koine\Repository\Exception\DomainException;
use Koine\Repository\Exception\RecordNotFoundException;

/**
 * Koine\Repository\Storage\StorageInterface
 */
interface StorageInterface
{
    /**
     * @param array $conditions
     *
     * @return bool
     */
    public function exists(array $conditions);

    /**
     * @param array $conditions
     *
     * @return array
     *
     * @throws RecordNotFoundException
     */
    public function findOneBy(array $conditions);

    /**
     * @param array $conditions
     * @param array $values
     */
    public function updateWhere(array $conditions, array $values);

    /**
     * @param array $conditions
     *
     * @return array
     */
    public function findAllBy(array $conditions = array(), $limit = null, $offset = 0);

    /**
     * @param mixed $id
     *
     * @return array
     *
     * @throws RecordNotFoundException when record is not found
     */
    public function find($id);

    /**
     * @param array $values
     *
     * @throws DomainException
     */
    public function insert(array $values);

    /**
     * @param array $conditions
     *
     * @throws DomainException
     */
    public function deleteWhere(array $conditions);
}
