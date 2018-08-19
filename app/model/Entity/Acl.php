<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby;

/**
 * @ORM\Entity
 */
final class Acl extends BaseEntity {

    use Kdyby\Doctrine\Entities\Attributes\Identifier;

    use Kdyby\Doctrine\Entities\MagicAccessors;

    const PRIVILEGE_ADDRESSBOOK = 0;
    const PRIVILEGE_SEARCH = 1;
    const RESOURCE_VILLAGE = 0;

    /**
     * @ORM\ManyToOne(targetEntity="UserAdmin")
     */
    protected $userAdmin;

    /**
     * @ORM\Column(type="integer")
     */
    protected $resource;

    /**
     * @ORM\Column(type="integer")
     */
    protected $privilege;

}
