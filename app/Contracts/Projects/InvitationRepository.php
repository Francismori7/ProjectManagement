<?php

namespace App\Contracts\Projects;

use App\Contracts\Core\BaseRepository;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface InvitationRepository extends BaseRepository
{
    /**
     * Returns all the Invitations.
     *
     * @return Collection All invitations.
     */
    public function findAll();

    /**
     * Returns all the Invitations.
     *
     * @param array $relations
     * @return Collection All invitations.
     */
    public function all(array $relations = []);

    /**
     * Find an invitation entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Invitation|null The invitation.
     */
    public function find($uuid, array $relations = []);

    /**
     * Find an invitation entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Invitation|null The invitation.
     */
    public function findByUUID($uuid, array $relations = []);

    /**
     * Find an invitation entity by email.
     *
     * @param string $email The email to look for in the database.
     * @param array $relations
     * @return Collection The invitation.
     */
    public function findByEmail($email, array $relations = []);

    /**
     * Find all invitations for a given project.
     *
     * @param Project $project The project to look for in the database.
     * @param array $relations
     * @return Collection The invitations.
     */
    public function findByProject(Project $project, array $relations = []);
}
