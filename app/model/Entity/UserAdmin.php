<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby;

/**
 * @ORM\Entity
 */
final class UserAdmin extends BaseEntity {

    use Kdyby\Doctrine\Entities\Attributes\Identifier;

    use Kdyby\Doctrine\Entities\MagicAccessors;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="UserAdminVillage", mappedBy="userAdmin")
     */
    protected $userAdminVillages;

}
