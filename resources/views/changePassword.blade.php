@extends('layouts.main')

@section('change-password')
    <aside>

        <!-- Attached Leftlist Here-->
        @include('layouts/leftlist')

        <div class="col-md-10 main-section">

            <!-- Display success message if available in the session -->
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display error message if available in the session -->
            @if (session('error'))
                <div class="alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <section>
                <h3 style="font-size:16px; font-weight:bold; color:#1C5978; text-align:left;margin-left:0px;">Change Password
                </h3>
                <hr style="margin:0px; width:600px; margin-bottom:10px" />
                <div
                    style=" background:#F3F1F1;border:1px solid silver; font: bold 13px/13px arial ;padding:5px 0px 5px 15px ">
                    Change Password</div>
                <div>
                    <form method="post" action="{{ url('/password-change-process') }}">
                        @csrf
                        <table class="addpage-table">
                            <tr>
                                <td>Old Password</td>
                                <td>
                                    <input type="password" name="oldPassword" id="oldPassword" required>
                                </td>
                            </tr>
                            <tr>
                                <td>New Password</td>
                                <td>
                                    <input type="password" name="newPassword" id="newPassword" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Confirm New Password</td>
                                <td>
                                    <input type="password" name="confNewPassword" id="confNewPassword" required>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">
                                    <input type="submit" class="srchbtn" name="save" value="Save" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </section>
        </div>
    </aside>
@endsection
