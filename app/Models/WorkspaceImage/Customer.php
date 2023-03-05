<?php

namespace App\Models\WorkspaceImage;

use Carbon\Carbon;
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

    public function setProfileImageAttribute($value)
    {
        if ($value) {
            $attribute_name = "image";
            $disk = "public";
            $destination_path = Carbon::now()->year . "/" . Carbon::now()->month . "/" . Carbon::now()->day;

            $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path, $fileName = null);
        }
        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
}
