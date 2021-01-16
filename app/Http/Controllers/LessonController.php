<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Subject;
use DateTime;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $lessons = DB::table('lessons')
            ->selectRaw('`lessons`.*, `subjects`.`id` as `sid`, `subjects`.`name` as `sname`')
            ->join('subjects', 'lessons.subject_id', '=', 'subjects.id')
            ->where('lessons.teacher_id', '=', Auth::user()->id)
            ->get();

        return view('teacher.lesson.index', ['lessons' => $lessons, 'grades' => Grade::all(), 'subjects' => Subject::where('teacher_id', '=', Auth::user()->id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('teacher.lesson.create',  ['grades' => Grade::all(), 'subjects' => Subject::where('teacher_id', '=', Auth::user()->id)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LessonRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(LessonRequest $request)
    {
        $lesson = new Lesson();
        $date = new DateTime($request->input('datetime'));

        $lesson->teacher_id = Auth::user()->id;
        $lesson->subject_id = $request->input('subject');
        $lesson->theme = $request->input('theme');
        $lesson->description = $request->input('description');
        $lesson->starts_at = $date->format(self::DATE_TIME_FORMAT);
        $lesson->finishes_at = $date->format(self::DATE_TIME_FORMAT);
        $lesson->grade_id = $request->input('grade');

        if($request->hasFile('file')) {
            $lesson->addMediaFromRequest('file')->toMediaCollection('files');
        }

        $lesson->save();
        return redirect()->route('main')->with('success', 'Урок был добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function show(Request $request)
    {
        $subject = $request->input('subject', '');
        $grade = $request->input('grade', '');
        $datetime = new DateTime($request->input('datetime', ''));

        $lessons = DB::table('lessons')
            ->selectRaw('`lessons`.*, `subjects`.`id` as `sid`, `subjects`.`name` as `sname`')
            ->join('subjects', 'lessons.subject_id', '=', 'subjects.id')
            ->where('lessons.teacher_id', '=', Auth::user()->id)
            ->where('subjects.id', '=', $subject)
            ->where('lessons.grade_id', '=', $grade)
            ->where('lessons.starts_at', '>=', $datetime->format(self::DATE_TIME_FORMAT))
            ->get();

        return view('teacher.lesson.index', ['lessons' => $lessons, 'grades' => Grade::all(), 'subjects' => Subject::where('teacher_id', '=', Auth::user()->id)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param Request $request
     * @return Application|Factory|View
     */
    public function edit($id, Request $request)
    {
        return view('teacher.lesson.create',  ['grades' => Grade::all(), 'subjects' => Subject::where('teacher_id', '=', Auth::user()->id)->get(), 'lesson' => Lesson::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function update($id, Request $request)
    {
        $lesson = Lesson::find($id);
        $date = new DateTime($request->input('datetime'));

        $lesson->teacher_id = Auth::user()->id;
        $lesson->subject_id = $request->input('subject');
        $lesson->theme = $request->input('theme');
        $lesson->description = $request->input('description');
        $lesson->starts_at = $date->format(self::DATE_TIME_FORMAT);
        $lesson->finishes_at = $date->format(self::DATE_TIME_FORMAT);
        $lesson->grade_id = $request->input('grade');

        if($request->hasFile('file')) {
            $lesson->addMediaFromRequest('file')->toMediaCollection('files');
        }

        $lesson->save();
        return redirect()->route('main')->with('success', 'Урок был отредактирован!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Lesson::find($id)->delete();
        return redirect()->route('teacher-lesson')->with('success', 'Урок удален!');
    }
}
