<?php

namespace App\Core\Controllers;

class IndexController extends Controller
{
    /**
     * Load up the angular app.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function angular()
    {
        return view('index');
    }
}
