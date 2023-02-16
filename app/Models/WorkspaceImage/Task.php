<?php

namespace App\Models\WorkspaceImage;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Task extends AbstractImageEntry
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public const STATUS_CREATED = 'CREATED';
    public const STATUS_IN_WORK = 'IN_WORK';
    public const STATUS_NEED_IN_WORK = 'NEED_IN_WORK';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_NOT_ACTUAL = 'NOT_ACTUAL';
    public const STATUS_COMPLETED = 'COMPLETED';

    public const STATUSES = [
        self::STATUS_PENDING => 'В Ожидании',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_NEED_IN_WORK => 'Требуется доработка',
        self::STATUS_CREATED => 'Создана',
        self::STATUS_NOT_ACTUAL => 'Не актуальна',
        self::STATUS_COMPLETED => 'Завершена',
    ];

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'name', 'description',
        'priority', 'status',
        'closed_at',
        'sprint_id', 'customer_id',
    ];

    protected $attributes = [
        'status' => self::STATUS_CREATED,
    ];

    public function sprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tags(): MorphToMany {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getTagsHtml() {
        $count = $this->tags->count();
        $resStr = '';
        foreach ($this->tags as $key => $tag) {
            $sym = ($count > 1 && $count !== $key + 1) ? ', ' : '';
            $resStr .= $tag->name . $sym;
        }

        return $count ? $resStr : '-';
    }
}
