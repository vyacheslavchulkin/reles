<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Homework extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'starts_at'   => 'date',
        'finishes_at' => 'date',
        'sent_at'     => 'timestamp',
    ];

    public function pupil(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pupil_id', 'id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }
}
