<?php

namespace Alzpk\LaravelChangeLog\Models\Traits;

use Alzpk\LaravelChangeLog\Enums\ChangeAction;
use Alzpk\LaravelChangeLog\Models\ChangeLog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use IteratorAggregate;

/**
 * @mixin Model
 * @property Collection&IteratorAggregate<ChangeLog> $changes
 */
trait HasChangeLog
{
    public static function bootHasChangeLog(): void
    {
        // Insert change log on created
        static::created(function (Model $model) {
            ChangeLog::query()->create([
                'loggable_id' => $model->{$model->primaryKey},
                'loggable_type' => get_class($model),
                'action' => ChangeAction::CREATED,
                'data_from' => null,
                'data_to' => $model->getAttributes(),
            ]);
        });

        // Insert change log on updated
        static::updated(function (Model $model) {
            ChangeLog::query()->create([
                'loggable_id' => $model->{$model->primaryKey},
                'loggable_type' => get_class($model),
                'action' => ChangeAction::UPDATED,
                'data_from' => $model->getOriginal(),
                'data_to' => $model->getAttributes(),
            ]);
        });

        // Insert change log on deleted
        static::deleted(function (Model $model) {
            ChangeLog::query()->create([
                'loggable_id' => $model->{$model->primaryKey},
                'loggable_type' => get_class($model),
                'action' => ChangeAction::DELETED,
                'data_from' => $model->getAttributes(),
                'data_to' => null,
            ]);
        });
    }

    public function changes(): MorphMany
    {
        return $this->morphMany(ChangeLog::class, 'loggable');
    }

    public function revertLatestChanges(): void
    {
        // Find the latest change
        $this->revert($this->changes()->latest()->first());
    }

    public function revertChangesById(int $changeLogId): void
    {
        $this->revert($this->changes()->firstWhere('id', $changeLogId));
    }

    private function revert(null|ChangeLog $changeLog): void
    {
        // If there's no change log, we don't revert anything
        if (!$changeLog instanceof ChangeLog) {
            return;
        }

        // If the change log is created, we force fill the data to
        if ($changeLog->action === ChangeAction::CREATED) {
            $this->forceFill($changeLog->data_to)->save();
        }

        // If the change log is updated, we force fill the data from
        if ($changeLog->action === ChangeAction::UPDATED) {
            $this->forceFill($changeLog->data_from)->save();
        }
    }
}
