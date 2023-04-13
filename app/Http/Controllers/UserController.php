<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * 
 * note: if you wonder what is apiResponse method, you can go to Controller.php file
 * instead of doing the same job, i put them into one function with following parameter :
 * - $status for error code, in order to return them into response
 * - $result
 * 
 * i do such things in order to add more efficieny, Hope this helps!
 * 
 */
class UserController extends Controller
{

    public function signup(Request $request){
        
        //validate all the incoming request input
        $validateInput = Validator::make($request->all(),[
            'username' => 'required|string|min:2',
            'password' => 'required|string|min:5',
            'fullname' => 'required|string'
        ],[],[
            'username' => 'Username',
            'password' => 'Password',
            'fullname' => 'Full Name'
        ]);

        //conditions if one of the input is not fulfilling the condition according to the validator
        if ($validateInput->fails()) {
            return response()->json(Controller::apiResponse(400,$validateInput->getMessageBag()->toArray()),400);
        }

        //checking if the username already exist or not
        $findUsername = DB::table('users')->where('username','=',$request->username)->count();
        if ($findUsername == 1) {
            return response()->json(Controller::apiResponse(409,"Username already Taken"),409);
        }

        //making input process to the database using try catch case for error handling
        try {
            DB::table('users')->insert([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'fullname' => $request->fullname,
                'created_at' => Carbon::parse(now())->format("Y-m-d H:i:s"),
                'updated_at' => Carbon::parse(now())->format("Y-m-d H:i:s")
            ]);
            return response()->json(Controller::apiResponse(200,"Sign Up Successful"),200);
        } catch (Exception $e) {
            return response()->json(Controller::apiResponse(400,$e->getMessage() ),400);
        }
    }

    public function login(Request $request){
        //making sure the only request that can pass the function is only both username and password
        $credentials = $request->only('username','password');

        //validate all the incoming input
        $validateInput = Validator::make($request->all(), [
            'username' => 'required|string|min:2',
            'password' => 'required|string|min:5',
        ],[],[
            'username' => 'Username',
            'password' => 'Password',
        ]);

        //conditions if one of the input is invalid
        if ($validateInput->fails()) {
            return response()->json(Controller::apiResponse(400,$validateInput->getMessageBag()->toArray()),400);
        }

        $user = User::where('username', $request->username)->first();
        $password_check = Hash::check($request->password, $user->password);
        if (!$password_check) {
            return response()->json(Controller::apiResponse(400,"Invalid Password"),400);
        }

        $token = JWTAuth::fromUser($user);
        try {
            if (!$token) {
                return response()->json(Controller::apiResponse(400,"Invalid Credentials"),400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json(Controller::apiResponse(500,"Generate Token Failed"), 500);
        }
 	
 		//Token created, return with success response and jwt token
        return response()->json(Controller::apiResponse(200,['token' => $token]),200);


    }
}
