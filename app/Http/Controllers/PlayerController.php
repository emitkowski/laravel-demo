<?php

namespace App\Http\Controllers;

use App\Models\Player;

/**
 * Class PlayerController
 *
 * @package App\Http\Controllers
 */
class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('players.index');
    }


    /**
     * Display the specified resource.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return view('players.show', compact('player'));
    }

}
