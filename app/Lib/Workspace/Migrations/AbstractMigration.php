<?php

namespace App\Lib\Workspace\Migrations;

use App\Models\Workspace;

abstract class AbstractMigration
{
    protected string $table;
    protected bool $alreadyExists = false;

    public function __construct(protected Workspace $workspace)
    {

    }

    public function up() {
        if (!$this->alreadyExists) {
            $this->workspace->connect()->create($this->table, $this->upClosure());
        } else {
            $this->workspace->connect()->table($this->table, $this->upClosure());
        }
    }

    /**
     * @return \Closure
     */
    abstract public function upClosure(): \Closure;

    /**
     * It needs if you modify your table (non create)
     * @return \Closure
     */
    abstract public function downClosure(): \Closure;

    public function down()
    {
        if (!$this->alreadyExists) {
            $this->workspace->connect()->dropIfExists($this->table);
        } else {
            $this->workspace->connect()->table($this->table, $this->downClosure());
        }
    }

    public function getTable(): string
    {
        return $this->table;
    }
}
