<?php

namespace App\Auth\Models;

use App\Core\Models\BaseEntity;
use App\Auth\Traits\HasRoles;
use App\Core\ACL\Traits\HasPermissions;
use App\Auth\Traits\AuthenticatesUsers;
use App\Contracts\ACL\HasRoles as HasRolesContract;
use App\Contracts\ACL\HasPermissions as HasPermissionsContract;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Auth\Passwords\CanResetPassword;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Foundation\Auth\Access\Authorizable;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\ORM\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class User.
 *
 * @ORM\Entity(repositoryClass="App\Auth\Repositories\DoctrineUserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseEntity implements Authenticatable,
                                         CanResetPasswordContract,
                                         AuthorizableContract,
                                         HasPermissionsContract,
                                         HasRolesContract
{
    use Timestamps,
        SoftDeletes,
        AuthenticatesUsers,
        CanResetPassword,
        Authorizable,
        HasPermissions,
        HasRoles;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     *
     * @var string The identifier of the user.
     */
    protected $id;
    /**
     * @ORM\Column(type="string", unique=true, length=30, name="username")
     *
     * @var string
     */
    protected $username;
    /**
     * @ORM\Column(type="string", length=50, name="first_name")
     *
     * @var string
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=50, name="last_name")
     *
     * @var string
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    protected $email;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    /**
     * Returns the User's identification number.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the User's username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Overwrites the User's username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Returns the User's first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Overwrites the User's first name.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Returns the User's last name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Overwrites the User's last name.
     *
     * @param mixed $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Returns the User's email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Overwrites the User's email address.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
