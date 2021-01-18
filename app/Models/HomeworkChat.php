<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int|mixed homework_id
 * @property int|mixed sender_id
 * @property mixed|string message
 */
class HomeworkChat extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'homework_chat';

    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class, "homework_id", "id");
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, "sender_id", "id");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }
}
