<?php

namespace App\Model\Service;

use Nette;
use App\Model\Entity\BaseEntity;
use Kdyby\Doctrine\EntityManager;

abstract class BaseService {

    use Nette\SmartObject;

    /** @var EntityManager */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    protected function flush() {
        return $this->em->flush();
    }

    protected function persist(BaseEntity $entity) {
        return $this->em->persist($entity);
    }

    protected function removeEntity(BaseEntity $entity) {
        return $this->em->remove($entity);
    }

}
