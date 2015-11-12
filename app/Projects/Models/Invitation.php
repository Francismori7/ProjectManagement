<?php

namespace App\Projects\Models;

use App\Core\Models\BaseEntity;
use App\Core\ACL\Traits\HasPermissions;
use App\Contracts\ACL\HasPermissions as HasPermissionsContract;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Invitation.
 *
 * @ORM\Entity(repositoryClass="App\Auth\Repositories\DoctrineRoleRepository")
 * @ORM\Table(name="roles")
 * @ORM\HasLifecycleCallbacks
 */
class Invitation extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     *
     * @var string
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Project", cascade={"all"}, fetch="EAGER")
     *
     * @var string
     */
    protected $project;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var string
     */
    protected $used;

    /**
     * Create a new role.
     */
    public function __construct()
    {
        $this->project = new Project;
        $this->used = 0;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param string $project
     * @return Invitation
     */
    public function setProject($project)
    {
        $this->project = $project;
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
     * @return Invitation
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @param string $used
     * @return Invitation
     */
    public function setUsed($used)
    {
        $this->used = $used;
        return $this;
    }
}
