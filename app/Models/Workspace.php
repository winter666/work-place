<?php

namespace App\Models;

use App\Observers\WorkspaceObserver;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Lib\WorkspaceStatusesConst;

/**
 * Class Workspace
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property string name
 * @property string status
 * @property string password
 */
class Workspace extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'workspaces';
    protected $attributes = [
        'status' => WorkspaceStatusesConst::STATUS_CREATED,
    ];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'name', 'password', 'status'];
    protected $hidden = ['password'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
