<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'starts_at'   => 'date',
        'finishes_at' => 'date',
    ];

    public function videos(): MorphToMany
    {
        return $this->morphToMany(Video::class, 'object', 'videos_pivot');
    }

    public function materials(): MorphToMany
    {
        return $this->morphToMany(Material::class, 'object', 'materials_pivot');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }
}
