<?php

namespace App\Lib\Workspace\Migrations;

use Illuminate\Database\Schema\Blueprint;

class CustomersMigration extends AbstractMigration
{

    public function up()
    {
        $this->workspace->connect()->create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->workspace->connect()->dropIfExists('customers');
    }
}
