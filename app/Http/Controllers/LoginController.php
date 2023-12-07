<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Handle the login request and authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginData(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Retrieve user from the database based on the provided username
        $credentials = $request->only('username', 'password');
        $user = Login::where('username', $credentials['username'])->first();

        if ($user && $user->password === $credentials['password']) {
            // Authentication successful
            Auth::login($user);
            return redirect()->intended('/upload-csv');
        }

        // Authentication failed
        return redirect("/")->with('error', 'Oops! You have entered invalid credentials');
    }


     /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }


     /**
     * Handle the password change request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordChange(Request $request)
    {
        if ($request->isMethod('post')) {

            $oldpw = $request->get('oldPassword');
            $newpw = $request->get('newPassword');
            $cnewp = $request->get('confNewPassword');

            if ($newpw == $cnewp) {

                $data = Login::where('password', $oldpw)->first();

                if (isset($data)) {
                    $data->password = $newpw;
                    $data->save();
                    return redirect()->back()->with("success", "Password Updated Successfully");
                } else {
                    return redirect()->back()->with("error", "Old Password not match");
                }
            } else {
                return redirect()->back()->with("error", "New password and Confirm new password does not match");
            }
        }
    }
}
