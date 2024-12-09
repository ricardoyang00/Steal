<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use App\Models\Administrator;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Game $game): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): bool
    {
        //
    }

    /**
     * Determine whether the user can block the game.
     */
    public function block($user, Game $game)
    {
        return is_admin()
        ? Response::allow()
        : Response::deny('You do not have permission to block this game.');
    }

    /**
     * Determine whether the user can unblock the game.
     */
    public function unblock($user, Game $game)
    {
        return is_admin()
        ? Response::allow()
        : Response::deny('You do not have permission to unblock this game.');
    }
}
