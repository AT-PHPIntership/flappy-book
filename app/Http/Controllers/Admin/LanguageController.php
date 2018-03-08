<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{

    /**
     * Display a list of the languages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.languages.index');
    }
}
