<?php

namespace Core\Mapper;

use Doctrine\ORM\EntityRepository;

class BaseMapper extends EntityRepository
{
    public function persist($entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
    }

    // One shot convenience method to immediately save entity to DB
    public function save($entity)
    {
        $em = $this->getEntityManager();
        $em->persist($entity);

        $em->flush();
        $em->clear();

        return $entity;
    }

    // One shot convenience method to immediately delete an entity from DB
    public function delete($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }
}
