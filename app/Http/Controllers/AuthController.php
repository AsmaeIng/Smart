<?php

namespace App\Http\Controllers;
use App\User;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Image;
class AuthController extends Controller
{
  //public $successStatus = 200;
    //register api
	/**
        * Create user
        *
        * @param  [string] name
        * @param  [string] email
        * @param  [string] password
        * @param  [string] password_confirmation
        * @return [string] message
        */
    public function register(Request $request)
        {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|',
                'c_password'=>'required|same:password',
            ]);

            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            if($user->save()){
				$iduser = $user->id;		
				 $img = new Images(); 
				 $img->name = 'intro-slide-1.png';
				 $img->user_id = $iduser;
				 $img->path = $path;
				 $img->save();
                return response()->json([
                    'message' => 'Successfully created user!'
                ], 201);
				
			
            }else{
                return response()->json(['error'=>'Provide proper details']);
            }
			// $id = $user->id;
			// $new = new users_roles(); 			
			// $new->role_id = $request['7'];
			// $new->user_id = $id;
			// $new->save();
          
		}
        

    // login api
      /**
    * Login user and create token
    *
    * @param  [string] email
    * @param  [string] password
    * @param  [boolean] remember_me
    * @return [string] access_token
    * @return [string] token_type
    * @return [string] expires_at
    */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
		 $images = Image::all();
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
       

    // user detail api
   /**
    * Get the authenticated User
    *
    * @return [json] user object
    */
    public function user(Request $request)
    {
      return response()->json($request->user());
    }

    // user logout api
     /**
    * Logout user (Revoke the token)
    *
    * @return [string] message
    */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
