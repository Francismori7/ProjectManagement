<?php

namespace App;

/*class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
    use Authenticatable, Authorizable, CanResetPassword;*/

use App\ORM\AuthenticatesUsers;
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
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements Authenticatable, CanResetPasswordContract, AuthorizableContract
{
    use Timestamps, SoftDeletes, AuthenticatesUsers, CanResetPassword, Authorizable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=16)
     * @var string The identifier of the user.
     */
    protected $id;
    /**
     * @ORM\Column(name="display_name", type="string", length=75)
     * @var string
     */
    protected $displayName;
    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $email;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $password;
    /**
     * @ORM\Column(name="remember_token", type="string", nullable=true)
     * @var string
     */
    protected $rememberToken;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return User
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param string $rememberToken
     * @return User
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;
        return $this;
    }
}
