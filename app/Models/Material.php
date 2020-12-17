<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Material extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function subjects(): MorphToMany
    {
        return $this->morphedByMany(Subject::class, 'taggable');
    }

    public function lessons(): MorphToMany
    {
        return $this->morphedByMany(Lesson::class, 'taggable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }
}
