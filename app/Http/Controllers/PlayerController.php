<?php

namespace App\Http\Controllers;

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

}
