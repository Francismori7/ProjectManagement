<?php

namespace App\Projects\Repositories;

use App\Contracts\Projects\InvitationRepository;
use App\Core\Repositories\EloquentBaseRepository;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class EloquentInvitationRepository extends EloquentBaseRepository implements InvitationRepository
{
    /**
     * Returns all the Invitations.
     *
     * @return Collection All invitations.
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Invitations.
     *
     * @param array $relations
     * @return Collection All invitations.
     */
    public function all(array $relations = [])
    {
        return Invitation::with($relations)->get();
    }

    /**
     * Find an invitation entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Invitation|null The invitation.
     */
    public function find($uuid, array $relations = [])
    {
        return $this->findByUUID($uuid, $relations);
    }

    /**
     * Find an invitation entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Invitation|null The invitation.
     */
    public function findByUUID($uuid, array $relations = [])
    {
        return Invitation::where('id', $uuid)->with($relations)->first();
    }

    /**
     * Find an invitation entity by email.
     *
     * @param string $email The email to look for in the database.
     * @param array $relations
     * @return Invitation|null The invitation.
     */
    public function findByEmail($email, array $relations = [])
    {
        return Invitation::where('email', $email)->with($relations)->first();
    }

    /**
     * Find all invitations for a given project.
     *
     * @param Project $project The project to look for in the database.
     * @param array $relations
     * @return Collection The invitations.
     */
    public function findByProject(Project $project, array $relations = [])
    {
        return $project->invitations->load($relations);
    }
}