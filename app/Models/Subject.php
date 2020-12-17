<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Subject extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function videos(): MorphToMany
    {
        return $this->morphToMany(Video::class, 'object', 'videos_pivot');
    }

    public function materials(): MorphToMany
    {
        return $this->morphToMany(Material::class, 'object', 'materials_pivot');
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
