<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

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
}
