<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', 'Membuat ' . class_basename($model) . ' baru');
        });

        static::updated(function ($model) {
            $model->logActivity('updated', 'Memperbarui ' . class_basename($model));
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', 'Menghapus ' . class_basename($model));
        });
    }

    public function logActivity($activity_type, $description = null)
    {
        if (!auth()->check()) {
            return;
        }

        $properties = [
            'model' => get_class($this),
            'model_id' => $this->id,
            'changes' => $this->getDirty()
        ];

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => $activity_type,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'properties' => $properties,
            'last_seen_at' => now()
        ]);
    }

    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }
}
