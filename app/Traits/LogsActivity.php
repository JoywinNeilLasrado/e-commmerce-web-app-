<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            static::logAction($model, 'created');
        });

        static::updated(function ($model) {
            static::logAction($model, 'updated');
        });

        static::deleted(function ($model) {
            static::logAction($model, 'deleted');
        });
    }

    protected static function logAction($model, $action)
    {
        if (auth()->check()) {
            $changes = [];
            $description = '';
            $modelBaseName = class_basename(get_class($model));

            if ($action === 'updated') {
                // Only log the fields that actually changed
                $dirty = $model->getDirty();
                $original = \Illuminate\Support\Arr::only($model->getOriginal(), array_keys($dirty));
                // Remove hidden fields (like password)
                $hidden = $model->getHidden();
                $dirty = \Illuminate\Support\Arr::except($dirty, $hidden);
                $original = \Illuminate\Support\Arr::except($original, $hidden);

                $changes = [
                    'before' => $original,
                    'after' => $dirty,
                ];
                $changedFields = implode(', ', array_keys($dirty));
                $description = auth()->user()->name . " updated {$modelBaseName} #{$model->getKey()} (changed: {$changedFields})";
            } elseif ($action === 'created') {
                $attrs = \Illuminate\Support\Arr::except($model->getAttributes(), $model->getHidden());
                $changes = [
                    'attributes' => $attrs,
                ];
                $description = auth()->user()->name . " created a new {$modelBaseName} #{$model->getKey()}";
            } elseif ($action === 'deleted') {
                $description = auth()->user()->name . " deleted {$modelBaseName} #{$model->getKey()}";
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'description' => $description,
                'model_type' => get_class($model),
                'model_id' => $model->getKey(),
                'changes' => empty($changes) ? null : $changes,
            ]);
        }
    }
}
