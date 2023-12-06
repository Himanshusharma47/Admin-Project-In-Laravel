<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // login data function start here
    public function loginData(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        // Retrieve the user from the database based on the provided username
        $user = Login::where('username', $credentials['username'])->first();

        if ($user && $user->password === $credentials['password']) {

            // Authentication successful
            Auth::login($user);
            return redirect()->intended('/upload-image');
        }
        return redirect("/")->with('error', 'Oops! You have entered invalid credentials');
    }

//   function for destroy the data by session
    public function logout(){
        Session::flush();
        Auth::logout();

        return Redirect('/login-form');
    }



    public function passwordChange(Request $request)
    {
        if($request->isMethod('post'))
        {
            $oldpw = $request->get('oldPassword');
            $newpw = $request->get('newPassword');
            $cnewp = $request->get('confNewPassword');
          
            if($newpw == $cnewp){
                $data = Login::where('password',$oldpw)->first();
                if(isset($data))
                {
                    $data->password = $newpw;
                    $data->save();
                    return redirect()->back()->with("success","Password Updated Successfully");
                }
                else
                {
                    return redirect()->back()->with("error","Old Password not match");
                }
            }
            else
            {
                return redirect()->back()->with( "error","New password and Confirm new password does not match");
            }

        }
    }
}
