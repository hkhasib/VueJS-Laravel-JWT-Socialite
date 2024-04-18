<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','redirectGoogle','callbackGoogle',
            'redirectTwitter','callbackTwitter']]);
    }

    public function register(Request $request){
        try{
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                ]);
            UserAddress::create([
                'user_id'=>$user->id,
                'city'=>$request->city,
                'country'=>$request->country,
                'postal_code'=>$request->postal_code
            ]);

            return response()->json([
               'status'=>'success',
               'message'=>'You have been registered!'
            ]);
        }
        catch (\Throwable $th){
            return response()->json([
               'status'=>'error',
               'message'=>$th->getMessage()
            ]);
        }
    }

    public function redirectGoogle(){
        $url= Socialite::driver('google')->redirect()->getTargetUrl();

        return response()->json([
            "url"=>$url
        ]);
    }
    public function callbackGoogle(){
        try{
            $google_user = Socialite::driver('google')->user();
            //return [$google_user->getEmail(),$google_user->getId(), $google_user->getName()];
            $user=User::where('google_id',$google_user->getId())->first();

            if(!$user){
                $new_user=User::create([
                    'name'=>$google_user->getName(),
                    'email'=>$google_user->getEmail(),
                    'google_id'=>$google_user->getId(),
                ]);
                if(!$token=Auth::login($new_user)){
                    return response()->json([
                        'status'=>'error',
                        'message'=>'Something went wrong'
                    ]);
                }
                return $this->createNewToken($token);

//                return '<script type="text/JavaScript">
//     localStorage.setItem("token","'.$token.'");
//     window.location.href="/dashboard";
//     </script>'
//                ;

            }
            else{
                if(!$token=Auth::login($user)){
                    return response()->json([
                        'status'=>'error',
                        'message'=>'Something went wrong'
                    ]);
                }
                return $this->createNewToken($token);
//                return '<script type="text/JavaScript">
//     localStorage.setItem("token", "'.$token.'");
//     window.location.href="/dashboard";
//     </script>'
//                    ;
            }

        }
        catch (\Throwable $th){
            return response()->json([
                'status'=>'error',
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function redirectTwitter(){
        $url = Socialite::driver('twitter')->redirect()->getTargetUrl();
        return response()->json([
            "url"=>$url
        ]);
    }

    public function callbackTwitter(){
        try{
            $twitter_user = Socialite::driver('twitter')->user();
            //return [$google_user->getEmail(),$google_user->getId(), $google_user->getName()];
            $user=User::where('twitter_id',$twitter_user->getId())->first();

            if(!$user){
                $new_user=User::create([
                    'name'=>$twitter_user->getName(),
                    'email'=>$twitter_user->getEmail(),
                    'twitter_id'=>$twitter_user->getId(),
                ]);
                if(!$token=Auth::login($new_user)){
                    return response()->json([
                        'status'=>'error',
                        'message'=>'Something went wrong'
                    ]);
                }
                return $this->createNewToken($token);

//                return '<script type="text/JavaScript">
//     localStorage.setItem("token","'.$token.'");
//     window.location.href="/dashboard";
//     </script>';



            }
            else{
                if(!$token=Auth::login($user)){
                    return response()->json([
                        'status'=>'error',
                        'message'=>'Something went wrong'
                    ]);
                }
                return $this->createNewToken($token);
//                return '<script type="text/JavaScript">
//     localStorage.setItem("token", "'.$token.'");
//     window.location.href="/dashboard";
//     </script>';
            }

        }
        catch (\Throwable $th){
            return response()->json([
                'status'=>'error',
                'message'=>$th->getMessage()
            ]);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!$token=\auth()->attempt($credentials)){
            return response()->json(['error'=>'Invalid credentials! Unauthorized!'],401);
        }

        return $this->createNewToken($token);
    }

    public function logout(){
        \auth()->logout();
        return response()->json(['message'=>'User successfully logged out!']);
    }

    public function detailedProfile($id){
        $user=User::where('id',$id)->first();
        return response()->json([
            'status'=>'success',
            'data'=>$user
        ]);
    }

    public function profile(){
        return response()->json(['data'=>\auth()->user()]);
    }

    public function createNewToken($token){
        return response()->json([
           'access_token'=>$token,
           'token_type'=>'bearer',
           'expires_in'=>\auth()->factory()->getTTL(),
           'user'=>\auth()->user()
        ]);
    }


}
