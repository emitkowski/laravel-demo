<?php

namespace App\Http\Controllers;

use CountryState;

/**
 * Class GeoController
 *
 * @package App\Http\Controllers
 */
class GeoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Get States
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function states()
    {
        return response()->json(['states' => CountryState::getStates('US')]);
    }

    /**
     * Get Countries
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countries()
    {
        $countries = CountryState::getCountries();
        asort($countries);

        return response()->json(['countries' => $countries]);
    }
}
