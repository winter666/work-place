<?php

namespace App\Lib\Workspace\Migrations;

use Illuminate\Database\Schema\Blueprint;

class CustomersMigration extends AbstractMigration
{
    protected string $table = 'customers';

    public function upClosure(): \Closure
    {
        return function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        };
    }

    public function downClosure(): \Closure
    {
        return function() {};
    }
}
