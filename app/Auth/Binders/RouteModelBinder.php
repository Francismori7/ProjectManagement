<?php

namespace App\Auth\Binders;

use App\Contracts\Projects\InvitationRepository;
use App\Projects\Models\Invitation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RouteModelBinder
{
    /**
     * @var InvitationRepository
     */
    private $invitationRepository;

    /**
     * RouteModelBinder constructor.
     * @param InvitationRepository $invitationRepository
     */
    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    /**
     * Binds the "invitation" key to the follow implementation.
     *
     * @param $id
     * @return Invitation|null
     */
    public function invitation($id)
    {
        $invitation = $this->invitationRepository->findByUUID($id);

        if (!$invitation) {
            throw (new ModelNotFoundException)->setModel(Invitation::class);
        }
        return $invitation;
    }
}