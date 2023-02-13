<?php


namespace App\Lib\Workspace\Migrations;


use Illuminate\Database\Schema\Blueprint;

class TasksMigration extends AbstractMigration
{
    protected string $table = 'tasks';

    public function upClosure(): \Closure
    {
        return function (Blueprint $table) {
           $table->string('name');
           $table->text('description');
           $table->string('tag');
           $table->unsignedBigInteger('sprint_id')->nullable();
           $table->unsignedBigInteger('customer_id')->nullable();
           $table->foreign('sprint_id')->references('id')->on('sprints');
           $table->foreign('customer_id')->references('id')->on('customers');
           $table->timestamps();
        };
    }

    public function downClosure(): \Closure
    {
        return function() {};
    }
}
