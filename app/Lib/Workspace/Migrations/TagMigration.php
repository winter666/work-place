<?php


namespace App\Lib\Workspace\Migrations;


use Illuminate\Database\Schema\Blueprint;

class TagMigration extends AbstractMigration
{
    protected string $table = 'tags';

    public function upClosure(): \Closure
    {
        return function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
        };
    }

    public function downClosure(): \Closure
    {
        return function (Blueprint $table) {};
    }
}
