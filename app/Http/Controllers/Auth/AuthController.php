<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Models\User as Users;
use App\Models\Master;
use App\Models\State;
use App\Helpers\Helpers as Helper;

class AuthController extends Controller {

    protected $error = '';

    public function index()
    {
     
    }
}
