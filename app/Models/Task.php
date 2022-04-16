<?php

namespace App\Models;

use App\Events\NewTaskEvent;
use App\Events\UpdateTaskEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property User $creator
 * @property mixed $priority
 * @property mixed $state
 * @property mixed $histories
 * @property mixed $id
 * @property mixed $title
 * @property mixed $due
 * @property User $assignee
 */
class Task extends Model
{

    protected $guarded = ['id'];

    use HasFactory;

    /**
     * @return BelongsTo
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TaskHistory::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function notificationSettings(): HasMany
    {
        return $this->hasMany(NotificationSetting::class);
    }

}
