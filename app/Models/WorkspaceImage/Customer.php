<?php

namespace App\Models\WorkspaceImage;

use Illuminate\Support\Facades\Hash;

class Customer extends AbstractImageEntry
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [ 'name', 'email', 'password' ];
    protected $hidden = ['password'];

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
}
