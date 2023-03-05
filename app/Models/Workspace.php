<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Lib\Workspace\WorkspaceStatusesConst;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

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
    protected $fillable = ['user_id', 'name', 'status', 'app_key'];
    protected $hidden = ['password'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function connect(): Builder
    {
        if ($this->id) {
            connectWorkspace($this);
            return Schema::connection('workspace');
        }

        throw new \Exception('Undefined workspace connection');
    }

    public function enterWorkspaceView()
    {
        return "
        <a class=\"btn btn-sm btn-link\" href=\"" . route('admin.workspace.entries', $this->id). "\">
            <i class=\"la la-sign-in-alt\"></i> Enter
        </a>";
    }

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
