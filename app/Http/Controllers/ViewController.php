<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Display the login form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function loginForm()
    {
        return view('index');
    }

    /**
     * Display the form for uploading CSV files.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function uploadCsv()
    {
        return view('uploadCsvFile');
    }

    /**
     * Display the form for uploading images.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function uploadImage()
    {
        return view('uploadImageCsv');
    }

    /**
     * Display the form for changing the password.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function changePassword()
    {
        return view('changePassword');
    }
}
