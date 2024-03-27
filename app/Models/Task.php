<?php

namespace App\Models;

use App\Enums\TaskProviders;
use App\Enums\TaskStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'status' => TaskStatuses::class,
        'provider' => TaskProviders::class,
        'due_date' => 'datetime',
    ];

    protected $appends = [
        'effort',
    ];

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function sprints(): BelongsToMany
    {
        return $this->belongsToMany(Sprint::class);
    }

    public function currentSprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class);
    }

    public function getEffortAttribute(): int
    {
        return $this->difficulty * $this->duration;
    }
}
