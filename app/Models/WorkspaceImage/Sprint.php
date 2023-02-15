<?php

namespace App\Models\WorkspaceImage;


use Illuminate\Database\Eloquent\Relations\HasMany;

class Sprint extends AbstractImageEntry
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [ 'name', 'description', 'start_at', 'end_at', 'closed_at' ];

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
