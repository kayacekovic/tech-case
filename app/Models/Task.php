<?php

namespace App\Models;

use App\Enums\TaskStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'status' => TaskStatuses::class,
    ];

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }
}
