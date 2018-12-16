<?php

namespace App\Http\Controllers;

use App\Models\Team;

/**
 * Class TeamController
 *
 * @package App\Http\Controllers
 */
class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return view('teams.show', compact('team'));
    }

}
