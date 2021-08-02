<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;

class SiteController extends Controller
{
    public function countries()
    {
        $countries = Country::all();
        return $this->sendResponse($countries, "Data fetch successfully.", 200);
    }

    public function countryState($id)
    {
        $states = State::where('country_id', $id)->get();
        return $this->sendResponse($states, "Data fetch successfully.", 200);
    }
}
