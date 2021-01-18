<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeworks = DB::table('homework')
            ->whereNull('homework.finishes_at')
            ->whereNotNull('homework.sent_at')
            ->leftJoin('users', 'users.id', '=', 'homework.pupil_id')
            ->get();

        return view('homework.teacher.index', ['homeworks' => $homeworks->all()]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param Homework $homework
     *
     * @return Response
     */
    public function show(Homework $homework)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Homework $homework
     *
     * @return Response
     */
    public function edit(Homework $homework)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param Homework $homework
     *
     * @return Response
     */
    public function update(Request $request, Homework $homework)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Homework $homework
     *
     * @return Response
     */
    public function destroy(Homework $homework)
    {
        //
    }
}
