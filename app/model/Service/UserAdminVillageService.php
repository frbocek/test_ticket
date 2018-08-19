<?php

namespace App\Model\Service;

use App\Model\Entity\UserAdminVillage;
use App\Model\Entity\UserAdmin;
use App\Model\Entity\Village;
use App\Model\Entity\Acl;
use Kdyby\Doctrine\EntityManager;

final class UserAdminVillageService extends BaseService {

    /** @var VillageService */
    private $villageService;

    /** @var AclService */
    private $aclService;

    public function __construct(EntityManager $em, VillageService $villageService, AclService $aclService) {
        parent::__construct($em);

        $this->villageService = $villageService;
        $this->aclService = $aclService;
    }

    /**
     * @param UserAdmin $userAdmin
     * @param int $privilege
     * @param array $rules  ex.: [ 1 => false, 2 => false ] ], kde 1 a 2 jsou ID Praha a Brno
     */
    public function setByAsocArray(UserAdmin $userAdmin, $privilege, Array $rules) {
        if (in_array(false, $rules)) {
            $this->aclService->remove($userAdmin, Acl::RESOURCE_VILLAGE, $privilege);

            foreach ($rules as $villageId => $allowed) {
                if ($allowed) {
                    $this->create($userAdmin, $this->villageService->find($villageId), $privilege);
                } else {
                    $this->remove($userAdmin, $this->villageService->find($villageId), $privilege);
                }
            }
        } else {
            $this->aclService->create($userAdmin, Acl::RESOURCE_VILLAGE, $privilege);
            $this->removeByUserAdmin($userAdmin, $privilege);
        }
    }

    public function create(UserAdmin $userAdmin, Village $village, $privilege) {
        if ($this->findBy(['userAdmin' => $userAdmin, 'village' => $village, 'privilege' => $privilege])) {
            return;
        }

        $userAdminVillage = new UserAdminVillage();
        $userAdminVillage->userAdmin = $userAdmin;
        $userAdminVillage->village = $village;
        $userAdminVillage->privilege = $privilege;

        $this->persist($userAdminVillage);
        $this->flush();

        return true;
    }

    public function remove(UserAdmin $userAdmin, Village $village, $privilege) {
        $entity = $this->findBy(['userAdmin' => $userAdmin, 'village' => $village, 'privilege' => $privilege]);

        if (!$entity) {
            return;
        }

        $this->em->remove($entity);
        $this->flush();
    }

    public function removeByUserAdmin(UserAdmin $userAdmin, $privilege) {
        foreach ($this->findBy(['userAdmin' => $userAdmin, 'privilege' => $privilege]) as $uav) {
            $this->removeEntity($uav);
        }

        $this->flush();
    }

    public function findBy(Array $arr) {
        return $this->getRepository()->findBy($arr);
    }

    private function getRepository() {
        return $this->em->getRepository(UserAdminVillage::class);
    }

}
