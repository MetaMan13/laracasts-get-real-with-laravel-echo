<?php

use App\Events\OrderStatusUpdated;
use App\Events\TaskCreated;
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

class Order
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('update', function(){
    // Dispatch the event
    OrderStatusUpdated::dispatch(new Order(13));
});

Route::get('/tasks', function(){
    return Task::all()->pluck('body');
});

Route::post('tasks', function(){
    $task = Task::create(request(['body']));

    TaskCreated::dispatch($task);
});
