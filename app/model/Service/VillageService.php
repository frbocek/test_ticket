<?php

namespace App\Model\Service;

use App\Model\Entity\Village;

final class VillageService extends BaseService {

    public function find($id) {
        return $this->getRepository()->find((int) $id);
    }

    public function findBy(Array $arr) {
        return $this->getRepository()->findBy($arr);
    }

    private function getRepository() {
        return $this->em->getRepository(Village::class);
    }

}
