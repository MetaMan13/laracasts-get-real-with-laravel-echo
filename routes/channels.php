<?php

use App\Models\Project;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('tasks.{project}', function ($user, Project $project) {
    // Code below works well for private channels
    // return $project->participants->contains($user);

    // Presence channels implementation
    if($project->participants->contains($user))
    {
        return ['name' => $user->name];
    }
});
