<?php


namespace App\Models\WorkspaceImage;


use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractImageEntry extends Model
{
    use HasFactory, CrudTrait;

    protected $connection = 'workspace';
}
