<?php

namespace App\Projects\Models;

use App\Core\Models\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * @ORM\Entity(repositoryClass="App\Projects\Repositories\DoctrineProjectRepository")
 * @ORM\Table(name="projects")
 * @ORM\HasLifecycleCallbacks
 */
class Project extends BaseEntity
{
    use Timestamps, SoftDeletes;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * Returns the Project's identification number.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the Project's description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Overwrite the Project's description.
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns the name of the Project.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Overwrites the name of the Project.
     *
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
