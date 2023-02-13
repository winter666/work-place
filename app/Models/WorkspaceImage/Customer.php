<?php

namespace App\Models\WorkspaceImage;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $connection = 'workspace';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [ 'name', 'email', 'password' ];
    protected $hidden = ['password'];
}
