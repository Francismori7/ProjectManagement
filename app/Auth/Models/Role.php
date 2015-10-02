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
     * @var Doctrine\Common\Collections\ArrayCollection|App\Auth\Models\User[]
     */
    protected $users;

    /**
     * Create a new role.
     */
    public function __construct()
    {
        $this->users = ArrayCollection;
        $this->permissions = ArrayCollection;
    }

    /**
     * Add a user to the role.
     *
     * @param App\Auth\Models\User $user
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
    }

    /**
     * Returns the role's users.
     *
     * @return Doctrine\Common\Collections\ArrayCollection|App\Auth\Models\User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}