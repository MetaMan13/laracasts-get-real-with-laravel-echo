<?php

use App\Events\TaskCreated;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/projects/{project}', function(Project $project){
    $project->load('tasks');

    return view('projects.show', compact('project'));
});

Route::get('/api/projects/{project}', function(Project $project){
    return $project->tasks->pluck('body');
});

Route::post('/api/projects/{project}/tasks', function(Project $project){
    $task = $project->tasks()->create(['body' => request('body'), 'project_id' => $project->id]);

    TaskCreated::dispatch($task);

    return $task->body;
});

require __DIR__.'/auth.php';
