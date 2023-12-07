<?php

namespace App\Http\Controllers\Api\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\EmailTemplate;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Response;
use Validator;
use DB;
use File;
use App\Models\User;
use App\Models\Module;
use App\Models\UserRole;
use App\Models\Role;
use Config;
use App\Helpers\Helpers as Helper;
use Carbon\Carbon;



class UserController extends Controller
{

    public function __construct()
    {
        $this->msg['status'] = 0;
        $this->msg['message'] = "success";
        $this->msg['data'] = array();
        $http_code = 200;
    }

    /**
     * Function to login user
     * Method: POST
     * Request URL: 
     * User will login into system using this api
     * Request Data: user data in json format
     * */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (!$validator->fails()) {
            $credentials = $request->only('email', 'password');
            try {
                if (!Auth::attempt($credentials)) {
                    return response()->json([
                        "status" => "error",
                        "message" => trans('messages.user_invalid_email_password'),
                        "code" => 401
                    ], 401);
                } else {
                    $user = Auth::user();
                    $role = UserRole::leftJoin('roles', 'roles.id', '=', 'user_roles.role_id')
                        ->where('user_roles.user_id', $user->id)
                        ->select('roles.id', 'roles.title')
                        ->get()
                        ->toArray()[0];

                    $token = $user->createToken('Laravel')->accessToken;

                    $userexpiredtime = User::select('update_password_date')
                        ->where('email', $request->input('email'))
                        ->first();
                    $from = Carbon::parse($userexpiredtime['update_password_date']);
                    $to = Carbon::parse(Carbon::now());
                    $diff_in_days = $to->diffInDays($from);
                    $exp_pass = ($diff_in_days >= 60) ? 1 : 0;

                    if ($user['status'] == 1) {
                        $user->save();
                        $response = [
                            "status" => "success",
                            "message" => trans('messages.user_login'),
                            "code" => 200,
                            "data" => [
                                "id" => $user->id,
                                "first_name" => $user->first_name,
                                "last_name" => $user->last_name,
                                "contact_number" => $user->contact_number,
                                "email" => $user->email,
                                "status" => $user->status,
                                "access_token" => $token,
                                "created_at" => $user->created_at->toISOString(),
                                "theme" => "auto",
                                "role" => $role,
                            ],
                            "exp_pass" => $exp_pass
                        ];
                        return response()->json($response, 200);
                    } else {
                        return response()->json([
                            "status" => "error",
                            "message" => trans('messages.user_inactive'),
                            "code" => 400
                        ], 400);
                    }
                }
            } catch (Exception $e) {
                return response()->json([
                    "status" => "error",
                    "message" => $e->getMessage(),
                    "code" => 500
                ], 500);
            }
        } else {
            $error_message = $validator->messages()->first();
            return response()->json([
                "status" => "error",
                "message" => $error_message,
                "code" => 400
            ], 400);
        }
    }


 


    /*
     * Method for forgot password 
    */
    public function forgotPassword(request $request)
    {
        $email = $request->input('email');

        // Check for email exist or not
        $user = DB::table('users')->select('name', 'last_name')->where('email', $email)->first();

        if(!empty($user)){
            // Update user password
            $randomPassword=$this->generateRandomString();
            $password = bcrypt($randomPassword);
            $affectedRows = User::where('email', $email)->update(array('password' => $password));

            if($affectedRows){
                // get forgot password template
                $fTemplate = DB::table('settings')->select('description')->where('id', 8)->first();

                $staticData = ["u_sendOn", "u_logo", "u_name","u_password", "current_year"];
                $repalceData   = [date('d M, Y'),url('/assets/images/logo_img.png'), $user->name . " " . $user->last_name, $randomPassword, date('Y')];

                $email_body =  str_replace($staticData, $repalceData, $fTemplate->description);

                // calling helper function
                $sendEmail =  Helper::sendEmail($email, 'Forgot Password', $email_body, 'Forgot Password');

                return response()->json($sendEmail);
            }
            else
            {
                $this->msg['status'] = 0;
                $this->msg['message'] = trans('messages.something_went_wrong');
                $http_code = '400';
            }

        }else{
            $this->msg['status'] = 0;
            $this->msg['message'] = trans('messages.email_not_found');
            $http_code = '400';
        }

        return response()->json($this->msg, $http_code);
       
    }


    //Function to generated random string password
    public function generateRandomString($length = 8) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}