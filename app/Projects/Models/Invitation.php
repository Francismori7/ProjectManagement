<?php

namespace App\Projects\Models;

use App\Core\Models\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Invitation.
 *
 * @ORM\Entity(repositoryClass="App\Projects\Repositories\DoctrineInvitationRepository")
 * @ORM\Table(name="invitations")
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
     * @ORM\ManyToOne(targetEntity="Project", cascade={"remove"}, fetch="EAGER")
     *
     * @var Project
     */
    protected $project;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $email;

    /**
     * Create a new role.
     */
    public function __construct()
    {
        $this->project = new Project;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return Invitation
     */
    public function setProject(Project $project)
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
}
