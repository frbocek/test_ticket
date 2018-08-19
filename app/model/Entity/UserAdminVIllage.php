<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby;

/**
 * @ORM\Entity
 */
final class UserAdminVillage extends BaseEntity {

    use Kdyby\Doctrine\Entities\Attributes\Identifier;

    use Kdyby\Doctrine\Entities\MagicAccessors;

    const PRIVILEGE_ADDRESSBOOK = 0;
    const PRIVILEGE_SEARCH = 1;

    /**
     * @ORM\ManyToOne(targetEntity="UserAdmin", inversedBy="userAdminVillages")
     */
    protected $userAdmin;

    /**
     * @ORM\ManyToOne(targetEntity="Village", inversedBy="userAdminVillages")
     */
    protected $village;

    /**
     * @ORM\Column(type="integer")
     */
    protected $privilege;

}
