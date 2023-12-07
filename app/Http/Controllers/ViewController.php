<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    // Display the login form
    public function loginForm()
    {
        return view('index');
    }

    // Display the form for uploading CSV files
    public function uploadCsv()
    {
        return view('uploadCsvFile');
    }

    // Display the form for uploading images
    public function uploadImage()
    {
        return view('uploadImageCsv');
    }

    // Display the form for change password
    public function changePassword()
    {
        return view('changePassword');
    }
}
