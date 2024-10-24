<?php

namespace Alzpk\LaravelChangeLog\Models;

use Alzpk\LaravelChangeLog\Enums\ChangeAction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property ChangeAction $action
 * @property null|array $data_from
 * @property null|array $data_to
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 */
class ChangeLog extends Model
{
    protected $fillable = [
        'loggable_type',
        'loggable_id',
        'action',
        'data_from',
        'data_to',
    ];

    protected $casts = [
        'action' => ChangeAction::class,
        'data_from' => 'array',
        'data_to' => 'array',
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
