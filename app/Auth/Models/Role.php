<?php

namespace App\Auth\Models;

use App\Core\Models\BaseEntity;
use App\Core\ACL\Traits\HasPermissions;
use App\Contracts\ACL\HasPermissions as HasPermissionsContract;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Role.
 *
 * @ORM\Entity(repositoryClass="App\Auth\Repositories\DoctrineRoleRepository")
 * @ORM\Table(name="roles")
 * @ORM\HasLifecycleCallbacks
 */
class Role extends BaseEntity implements HasPermissionsContract
{
    use HasPermissions;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Auth\Models\User", mappedBy="role_user")
     *
     * @var ArrayCollection|User[]
     */
    protected $users;

    /**
     * Create a new role.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection;
        $this->permissions = new ArrayCollection;
    }

    /**
     * Add a user to the role.
     *
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
    }

    /**
     * Returns the role's users.
     *
     * @return ArrayCollection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}
