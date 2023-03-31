<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;

class SocialLoginController extends Controller
{
    public function index(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $googleUserData = Socialite::driver('google')->user();
        $user=User::where('email',$googleUserData->email)->first();
        if(!$user){
            $user=User::create([
                    'firstname'=>$googleUserData->user['given_name'],
                    'lastname'=>$googleUserData->user['family_name'],
                    'email'=>$googleUserData->email,
                    'login_type'=>'google',
                    'password'=>hash::make($googleUserData->email)
                ]);
            $user->markEmailAsVerified();
        }
        Auth::login($user);
        return redirect('/dashboard');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}