<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'project_tasks');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'project_participants');
    }
}
