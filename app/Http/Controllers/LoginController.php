<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Login data function starts here
    public function loginData(Request $request)
    {
        // Validate username and password from the request
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Retrieve user from the database based on the provided username
        $credentials = $request->only('username', 'password');
        $user = Login::where('username', $credentials['username'])->first();

        // Check if user exists and password is correct
        if ($user && $user->password === $credentials['password']) {
            // Authentication successful
            Auth::login($user);
            return redirect()->intended('/upload-image');
        }

        // Authentication failed
        return redirect("/")->with('error', 'Oops! You have entered invalid credentials');
    }

    // Function to destroy the data by session and log out
    public function logout()
    {
        Session::flush();
        Auth::logout();

        // redirect to the login page
        return redirect('/');
    }

    // Function to handle password
    public function passwordChange(Request $request)
    {
        if ($request->isMethod('post')) {

            $oldpw = $request->get('oldPassword');
            $newpw = $request->get('newPassword');
            $cnewp = $request->get('confNewPassword');

            // Check if new password and confirm new password match
            if ($newpw == $cnewp) {

                $data = Login::where('password', $oldpw)->first();

                // If user found, update the password
                if (isset($data)) {
                    $data->password = $newpw;
                    $data->save();
                    return redirect()->back()->with("success", "Password Updated Successfully");
                } else {
                    // Old password does not match
                    return redirect()->back()->with("error", "Old Password not match");
                }
            } else {
                // New password and confirm new password do not match
                return redirect()->back()->with("error", "New password and Confirm new password does not match");
            }
        }
    }
}
