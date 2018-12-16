<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class AddressPolicy
 *
 * @package App\Policies
 */
class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param $id
     * @return bool
     */
    public function view(User $user, $id)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->currentTeam->id == $id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User $user
     * @param $id
     * @return mixed
     */
    public function create(User $user, $id)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->currentTeam->id == $id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User $user
     * @param  Address $model
     * @return mixed
     */
    public function update(User $user, Address $model)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->currentTeam->id == $model->addressable->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Address $model
     * @return bool
     */
    public function delete(User $user, Address $model)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->currentTeam->id == $model->addressable->id) {
            return true;
        }

        return false;
    }
}
