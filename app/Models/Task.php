<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $creator
 * @property mixed $priority
 * @property mixed $state
 * @property mixed $history
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

    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class);
    }

}
