<?php

namespace App\Models;

use App\Http\Controllers\LessonController;
use App\Http\Requests\LessonRequest;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'starts_at' => 'date',
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

    /**
     * @param string $subjectId
     * @param string $gradeId
     * @param string $datetime
     * @return Collection
     * @throws Exception
     */
    public function getLessonsWithFilter(
        string $subjectId = '',
        string $gradeId = '',
        string $datetime = ''
    ): Collection {
        $datetime = $this->getFormatDate($datetime);

        return DB::table('lessons')
            ->selectRaw('`lessons`.*, `subjects`.`id` as `sid`, `subjects`.`name` as `sname`')
            ->join('subjects', 'lessons.subject_id', '=', 'subjects.id')
            ->where('lessons.teacher_id', '=', Auth::user()->id)
            ->where('subjects.id', '=', $subjectId)
            ->where('lessons.grade_id', '=', $gradeId)
            ->where('lessons.starts_at', '>=', $datetime)
            ->get();
    }

    /**
     * @param string $datetime
     * @return string
     * @throws Exception
     */
    public function getFormatDate(string $datetime): string
    {
        if ($datetime === '') {
            return '';
        }
        $datetime = new DateTime($datetime);
        return $datetime->format(LessonController::DATE_TIME_FORMAT);
    }

    public function saveOrUpdate(Lesson $lesson, LessonRequest $request): void
    {
        $date = new DateTime($request->input('datetime'));

        $lesson->teacher_id = Auth::user()->id;
        $lesson->subject_id = $request->input('subject');
        $lesson->theme = $request->input('theme');
        $lesson->description = $request->input('description');
        $lesson->starts_at = $date->format(LessonController::DATE_TIME_FORMAT);
        $lesson->finishes_at = $date->format(LessonController::DATE_TIME_FORMAT);
        $lesson->grade_id = $request->input('grade');

        if ($request->hasFile('file')) {
            $lesson->addAllMediaFromRequest()->each(
                function ($fileAdder) {
                    $fileAdder->toMediaCollection('files');
                }
            );
        }

        $lesson->save();
    }
}
