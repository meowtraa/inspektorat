<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TlBpk;
use Illuminate\Auth\Access\HandlesAuthorization;

class TlBpkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_tl::bpk');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TlBpk $tlBpk): bool
    {
        return $user->can('view_tl::bpk');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_tl::bpk');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TlBpk $tlBpk): bool
    {
        return $user->can('update_tl::bpk');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TlBpk $tlBpk): bool
    {
        return $user->can('delete_tl::bpk');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_tl::bpk');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, TlBpk $tlBpk): bool
    {
        return $user->can('force_delete_tl::bpk');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_tl::bpk');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, TlBpk $tlBpk): bool
    {
        return $user->can('restore_tl::bpk');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_tl::bpk');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, TlBpk $tlBpk): bool
    {
        return $user->can('replicate_tl::bpk');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_tl::bpk');
    }
}
