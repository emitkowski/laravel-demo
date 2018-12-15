<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
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

        if ($user->id == $id) {
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

        if ($user->id == $id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Attachment $model
     * @return bool
     */
    public function delete(User $user, Attachment $model)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->id == $model->model->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Attachment $model
     * @return bool
     */
    public function download(User $user, Attachment $model)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->id == $model->model->id) {
            return true;
        }

        return false;
    }

}
