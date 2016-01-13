<?php

namespace Koine\Repository;

use Koine\Repository\Entity\GeneratedIdInterface;

/**
 * Koine\Repository\IdAwareRepository
 */
class IdAwareRepository extends Repository
{
    /**
     * {@inheritdoc}
     *
     * @param GeneratedIdInterface $entity
     *
     * @return mixed
     */
    public function persist($entity)
    {
        return $this->persistEntity($entity);
    }

    /**
     * {@inheritdoc}
     *
     * @param GeneratedIdInterface $entity
     *
     * @return mixed
     */
    protected function persistEntity(GeneratedIdInterface $entity)
    {
        if ($entity->getId()) {
            return $this->update($entity);
        } else {
            return $this->insert($entity);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param GeneratedIdInterface $entity
     *
     * @return mixed
     */
    public function remove($entity)
    {
        return $this->removeEntity($entity);
    }

    /**
     * @param GeneratedIdInterface $entity
     *
     * @return int
     */
    protected function insert(GeneratedIdInterface $entity)
    {
        $data = $this->getHydrator()->extract($entity);
        $generatedId = $this->getStorage()->insert($data);

        if ($generatedId) {
            $entity->setGeneratedId($generatedId);
        }

        return $generatedId;
    }

    /**
     * @param GeneratedIdInterface $entity
     *
     * @return mixed
     */
    protected function update(GeneratedIdInterface $entity)
    {
        $data = $this->getHydrator()->extract($entity);

        $conditions = array(
            $this->getIdField() => $entity->getId(),
        );

        return $this->getStorage()->updateWhere($conditions, $data);
    }

    /**
     * @param GeneratedIdInterface $entity
     *
     * @return mixed
     */
    private function removeEntity(GeneratedIdInterface $entity)
    {
        $conditions = array(
            $this->getIdField() => $entity->getId(),
        );

        $result = $this->getStorage()->deleteWhere($conditions);
        $entity->setGeneratedId(null);

        return $result;
    }

    /**
     * @return string
     */
    protected function getIdField()
    {
        return 'id';
    }
}
