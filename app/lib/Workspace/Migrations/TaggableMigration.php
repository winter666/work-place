<?php


namespace App\Lib\Workspace\Migrations;


use Illuminate\Database\Schema\Blueprint;

class TaggableMigration extends AbstractMigration
{
    protected string $table = 'taggables';

    public function upClosure(): \Closure
    {
        return function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->string('taggable_id');
            $table->string('taggable_type');
            $table->foreign('tag_id')
                ->references('id')->on('tags')->cascadeOnDelete();
        };
    }

    public function downClosure(): \Closure
    {
        return function (Blueprint $table) {};
    }
}
