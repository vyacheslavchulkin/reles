<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use Notifiable;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'phone',
        'password',
        'telegram_chat_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeAdmins(Builder $builder): Builder
    {
        return $builder->where('user_type', RoleEnum::ADMIN);
    }

    public function scopeTeachers(Builder $builder): Builder
    {
        return $builder->where('user_type', RoleEnum::TEACHER);
    }

    public function scopePupils(Builder $builder): Builder
    {
        return $builder->where('user_type', RoleEnum::PUPIL);
    }

    public function homeworks(): HasMany
    {
        return $this->hasMany(Homework::class, 'pupil_id');
    }

    public function unfinishedHomeworks(): HasMany
    {
        return $this->homeworks()->whereNull('sent_at');
    }

    public function finishedHomeworks(): HasMany
    {
        return $this->homeworks()->whereNotNull(['sent_at', 'finished_at']);
    }

    public function sentHomeworks(): HasMany
    {
        return $this->homeworks()->whereNotNull(['sent_at'])->whereNull(['finished_at']);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
             ->singleFile();
    }
}
