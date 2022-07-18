<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\LoginHistory;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function otpSent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
        ]);
        if ($validator->fails()) {

            return [

                'code' => 400,
                'message' => "This Email Is Already Used , Please try another Email",
                'data' => $request->all(),
            ];
        }

        $email = $request['email'];

        $otp = getOtp();
        $is_exist = Otp::where('email', $email)->where('is_used', false)->orderBy('created_at', 'DESC')->first();
        if (!is_null($is_exist)) {
            if (Carbon::parse($is_exist->created_at)
                    ->addSeconds(getExpireLimit()) >= \Carbon\Carbon::now()) {
                $message = "You have an active OTP";
                $status_code = 201;

            } else {
                $status_code = 200;
                $message = "Check your Email for OTP";
                Otp::create([
                    'email' => $email,
                    'otp' => $otp,
                ]);
                $otp = " verification code is " . $otp;

                $data = array(

                    'name' => $request['name'],
                    'otp' => $otp,

                );
                Mail::send('mail', $data, function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Verification Email');
                    $message->from('saiful013101@gmail.com', 'Verification Email');
                });

            }
        } else {
            $status_code = 200;
            $message = "Check your Email for OTP";
            Otp::create([
                'email' => $email,
                'otp' => $otp,
            ]);
            $otp = " verification code is " . $otp;

            $data = array(

                'name' => $request['name'],
                'otp' => $otp,

            );
            Mail::send('mail', $data, function ($message) use ($email) {

                $message->to($email)
                    ->subject('Verification Email');
                $message->from('saiful013101@gmail.com', 'Verification Email');
            });
        }

        return [
            'code' => $status_code,
            'message' => $message,
            'data' => $request->all(),
            'status' => 200,
            'otp' => $otp,
        ];
    }

    public function registrationSave(Request $request)
    {
        $name = $request['name'];
        $email = $request['email'];
        $otp = $request['otp'];
        $password = $request['password'];
        $user_type = $request['user_type'];
        $user_id = 'user-' . time();

        $is_exist = OTP::where('email', $email)->where('otp', $otp)->where('is_used', false)->first();
        if (is_null($is_exist)) {
            return [
                'code' => 400,
                'message' => "OTP is invalid",
                'data' => $request->all(),
                'status' => 400

            ];
        } else {
            $code = 200;
            $message = "Successfully Verified and Saved";

            if (Carbon::parse($is_exist->created_at)
                    ->addSeconds(getExpireLimit()) < \Carbon\Carbon::now()) {
                return [
                    'code' => 400,
                    'message' => "OTP Expired",
                    'data' => $request->all(),
                    'status' => 400

                ];

            } else {
                User::insertGetId([
                    'name' => $name,
                    'email' => $email,
                    'user_id' => $user_id,
                    'user_type' => $user_type,
                    'password' => Hash::make($password),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $credentials = $request->only('email', 'password');
                Auth::guard('admin')->attempt($credentials);

            }
        }
        return [
            'code' => $code,
            'message' => $message,
            'data' => $request->all(),
            'status' => 200
        ];

    }

    public function adminDashboard(Request $request)
    {

        if (!Auth::guard('admin')->check()) {
            return redirect('/');
        }
        $query = User::OrderBy('created_at', "DESC");
        if ($request['user_type'] != null) {
            $query->where('user_type', $request['user_type']);
        }
        if ($request['user_input'] != null) {
            $query->where('name', $request['user_input'])->orWhere('user_id', $request['user_input']);
        }


        $data1 = $query->get();
        $new_array = [];
        foreach ($data1 as $item) {
            $new_array[] = $item;
        }


        if ($request['data'] != null) {
            $users = json_decode($request['data'], true);

            foreach ($users as $item) {
                $new_array[] = $item;
            }

        }
        $old_data = [];
        if ($request['user_type'] || $request['user_input'] != null) {
            $old_data = $new_array;
        }

        return view('admin.index')
            ->with('old_data', $old_data)
            ->with('result', $new_array);


    }

    public function agentDashboard(Request $request)
    {
        return view('agent.index');


    }

    public function userDashboard(Request $request)
    {
        return view('user.index');


    }

    public function login(Request $request)
    {
        return view('login');


    }

    public function LoginCheck(Request $request)
    {
        $exist = User::where('email', $request['email'])->first();
        if ($exist != null) {
            if (Auth::guard("admin")->attempt(['email' => $request['email'], 'password' => $request['password'], 'user_type' => 1],)) {

                return Redirect::to('/admin/dashboard');
            } elseif (Auth::guard("agent")->attempt(['email' => $request['email'], 'password' => $request['password'], 'user_type' => 2],)) {

                return Redirect::to('/agent/dashboard');
            } elseif (Auth::guard("user")->attempt(['email' => $request['email'], 'password' => $request['password'], 'user_type' => 3],)) {

                return Redirect::to('/user/dashboard');
            } else {

                Alert::error('Sorry! ', "Email or password does not match or Your are not active");
                return back()->withInput();


            }
        } else {

            Alert::error('Sorry! ', "You don't Have any account");
            return back()->withInput();


        }

    }


    public
    function adminLogout(Request $request)
    {
        Auth::logout();
        return Redirect::to('/');
    }

}
