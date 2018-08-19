<?php

namespace App\Model\Service;

use App\Model\Entity\UserAdmin;
use App\Model\Entity\Acl;
use App\Model\Service\UserAdminVillageService;
use App\Model\Service\AclService;
use App\Model\Service\VillageService;
use Kdyby\Doctrine\EntityManager;

final class UserAdminService extends BaseService {

    /** @var VillageService */
    private $villageService;

    /** @var AclService */
    private $aclService;

    /** @var UserAdminVillageService */
    private $userAdminVillageService;

    public function __construct(EntityManager $em, VillageService $villageService, AclService $aclService, UserAdminVillageService $userAdminVillageService) {
        parent::__construct($em);

        $this->villageService = $villageService;
        $this->aclService = $aclService;
        $this->userAdminVillageService = $userAdminVillageService;
    }

    public function create($name) {
        $userAdmin = new UserAdmin();
        $userAdmin->name = $name;
        $this->persist($userAdmin);

        $this->set($userAdmin, ['addressbook' => [], 'search' => []]);
        $this->flush();

        return $userAdmin;
    }

    /**
     * @param UserAdmin $userAdmin
     * @param Array     $privileges ex.: [ addressbook => [ 1 => true, 2 => false ] ,
     *                              search => [ 1 => false, 2 => false ] ], kde 1 a 2 jsou ID Praha a Brno
     */
    public function set(UserAdmin $userAdmin, Array $privileges) {
        $this->userAdminVillageService->setByAsocArray($userAdmin, Acl::PRIVILEGE_ADDRESSBOOK, $privileges['addressbook']);
        $this->userAdminVillageService->setByAsocArray($userAdmin, Acl::PRIVILEGE_SEARCH, $privileges['search']);

        $this->flush();

        return true;
    }

    public function get(UserAdmin $userAdmin, $privilege) {
        if ($this->aclService->isAllowed($userAdmin, Acl::RESOURCE_VILLAGE, $privilege)) {
            $villages = [];
            foreach ($this->villageService->findBy([]) as $village) {
                $villages[] = $village->id;
            }
            return $villages;
        }

        $villages = [];
        foreach ($this->userAdminVillageService->findBy(['userAdmin' => $userAdmin, 'privilege' => $privilege]) as $rule) {
            $villages[] = $rule->village->id;
        }

        return $villages;
    }

    public function find($id) {
        return $this->getRepository()->find((int) $id);
    }

    private function findOneBy(Array $arr) {
        return $this->getRepository()->findOneBy($arr);
    }

    private function getRepository() {
        return $this->em->getRepository(UserAdmin::class);
    }

}
