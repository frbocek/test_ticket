<?php

namespace App\Model\Service;

use App\Model\Entity\UserAdmin;
use App\Model\Entity\Acl;

final class AclService extends BaseService {

    public function create(UserAdmin $user, $resource, $privilege) {
        if ($this->findOneBy(['userAdmin' => $user, 'resource' => $resource, 'privilege' => $privilege])) {
            return;
        }

        $acl = new Acl();
        $acl->userAdmin = $user;
        $acl->resource = $resource;
        $acl->privilege = $privilege;

        $this->em->persist($acl);
        $this->em->flush();
    }

    public function isAllowed(UserAdmin $user, $resource, $privilege) {
        return (bool) $this->findOneBy(['userAdmin' => $user, 'resource' => $resource, 'privilege' => $privilege]);
    }

    public function remove(UserAdmin $user, $resource, $privilege) {
        $acl = $this->findOneBy(['userAdmin' => $user, 'resource' => $resource, 'privilege' => $privilege]);

        if (!$acl) {
            return;
        }

        $this->removeEntity($acl);
        $this->flush();
    }

    private function findOneBy(Array $arr) {
        return $this->getRepository()->findOneBy($arr);
    }

    private function getRepository() {
        return $this->em->getRepository(Acl::class);
    }

}
