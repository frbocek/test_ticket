<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby;

/**
 * @ORM\Entity
 */
final class Village extends BaseEntity {

    use Kdyby\Doctrine\Entities\Attributes\Identifier;

    use Kdyby\Doctrine\Entities\MagicAccessors;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="UserAdminVillage", mappedBy="village")
     */
    protected $userAdminVillages;

}
