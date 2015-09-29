<?php

namespace App\Auth\Models;

use App\Auth\Traits\AuthenticatesUsers;
use App\Core\Models\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use LaravelDoctrine\ORM\Contracts\Auth\Authenticatable;

/**
 * Class User
 * @package App
 * @ORM\Entity(repositoryClass="App\Repositories\DoctrineUserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseEntity implements Authenticatable, CanResetPasswordContract, AuthorizableContract
{
    use Timestamps, SoftDeletes, AuthenticatesUsers, CanResetPassword, Authorizable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     * @var string The identifier of the user.
     */
    protected $id;
    /**
     * @ORM\Column(type="string", unique=true, length=30, name="username")
     * @var string
     */
    protected $userName;
    /**
     * @ORM\Column(type="string", length=50, name="first_name")
     * @var string
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=50, name="last_name")
     * @var string
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $email;

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
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Overwrites the User's username.
     *
     * @param string $userName
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * Returns the User's first name.
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
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
