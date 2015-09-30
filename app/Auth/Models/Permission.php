<?php

namespace App\Auth\Models;

use App\Core\Models\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permission
 * @package App
 * @ORM\Entity(repositoryClass="App\Auth\Repositories\DoctrinePermissionRepository")
 * @ORM\Table(name="permissions")
 * @ORM\HasLifecycleCallbacks
 */
class Permission extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, name="pattern")
     * @var string
     */
    protected $pattern;

    /**
     * @ORM\Column(type="string", name="name")
     * @var [type]
     */
    protected $name;

    /**
     * Returns the Permission's identification number.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the Permission's unique pattern used for matching.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Overwrites Permission's pattern.
     *
     * @param  string $pattern
     * @return Permission
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this->pattern;
    }

    /**
     * Returns the Permission's display name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Overwrites the Permission's display name.
     *
     * @param  string $name
     * @return Permission
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this->name;
    }
}
