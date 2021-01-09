<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = DB::table('lessons')
            ->join('subjects', 'subjects.id', '=', 'lessons.subject_id')
            ->where('lessons.teacher_id', '=', Auth::user()->id)
            ->get();

        return view('teacher.lesson.index', ['lessons' => $lessons, 'grades' => Grade::all(), 'subjects' => Subject::where('teacher_id', '=', Auth::user()->id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.lesson.create',  ['grades' => Grade::all(), 'subjects' => Subject::where('teacher_id', '=', Auth::user()->id)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LessonRequest $request)
    {
        $lesson = new Lesson();
        $lesson->teacher_id = Auth::user()->id;
        $lesson->subject_id = $request->input('subject');
        $lesson->theme = $request->input('theme');
        $lesson->description = $request->input('description');
        $lesson->starts_at = '2021-01-01 10:10:00';
        $lesson->finishes_at = '2021-01-01 10:50:00';

        $lesson->save();
        return redirect()->route('main')->with('success', 'Урок был добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
