<?php


namespace App\Lib\Workspace\Migrations;


use Illuminate\Database\Schema\Blueprint;

class SprintsMigration extends AbstractMigration
{
    protected string $table = 'sprints';

    public function upClosure(): \Closure
    {
        return function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
        };
    }

    public function downClosure(): \Closure
    {
        return function() {};
    }
}
