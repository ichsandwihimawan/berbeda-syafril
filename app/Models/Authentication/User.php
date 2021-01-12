<?php

namespace App\Models\Authentication;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

// entrust
use Zizaco\Entrust\Traits\EntrustUserTrait;

// Models
use App\Models\Master\Karyawan;
use App\Models\Project\Project;
use App\Models\Project\Task;
use App\Models\Traits\Utilities;

class User extends Authenticatable
{
    use Utilities;
    use Notifiable;
    use EntrustUserTrait;

    public $table = 'sys_users';
    public $remember_token = false;

    protected $dates = ['last_login'];
    protected $fillable = [
      'username', 'password', 'email', 'deleted_at', 'last_login'
    ];

    /* Relation */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'user_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'trans_project_member', 'user_id', 'project_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'trans_task_personil', 'user_id', 'task_id');
    }
    /* End Relation */

    /* Mutator */
    
    /* End Mutator */

    /* Custom Function */

    /* End Custom Function */
}
