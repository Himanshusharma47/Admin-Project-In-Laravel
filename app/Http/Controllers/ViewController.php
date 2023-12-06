<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function loginForm()
    {
        return view('index');
    }
    public function uploadCsv()
    {
        return view('uploadCsvFile');
    }
    public function uploadImage()
    {
        return view('uploadImageCsv');
    }

    public function changePassword()
    {
        return view('changePassword');
    }
   
}
