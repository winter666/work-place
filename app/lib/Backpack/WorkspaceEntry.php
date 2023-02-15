<?php


namespace App\Lib\Backpack;


use App\Models\WorkspaceImage\AbstractImageEntry;

class WorkspaceEntry
{
    public function __construct(protected AbstractImageEntry $entry, protected string $icon)
    {
        //
    }

    public function getSubject(): string
    {
        return $this->entry->getTable();
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}
