<?php

namespace Koine\Repository;

/**
 * Koine\Repository\RepositoryInterface
 */
interface RepositoryInterface
{
    /**
     * @param object $entity
     *
     * @return mixed
     *
     * @throws Exception\DomainException
     */
    public function persist($entity);

    /**
     * @param object $entity
     *
     * @return mixed
     *
     * @throws Exception\DomainException
     */
    public function remove($entity);

    /**
     * @param array $params
     *
     * @return object
     *
     * @throws Exception\RecordNotFoundException
     */
    public function findOneBy(array $params);

    /**
     * @param array $params
     *
     * @return object[]
     * @return mixed
     */
    public function findAllBy(array $params);
}
