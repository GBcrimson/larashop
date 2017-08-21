<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Session;
use Mail;

class UserController extends Controller
{
    public function getSignup()
    {
        return view('user.signup');
    }

    public function postSignup(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'username' => 'required|min:4',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4'
        ]);
        $confirm_code = str_random(30);
        $confirmation_code = ['confirmation_code' => $confirm_code];

        $user = new User([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'confirmation_code' => $confirm_code
        ]);
        $user->save();

        Mail::send('mail.verify', $confirmation_code, function($message) {
            global $request;
            $message->to($request->input('email'), "lolkek")
                ->subject('Verify your email address');
        });

//        Auth::login($user);

//        if (Session::has('oldUrl')) {
//            $oldUrl = Session::get('oldUrl');
//            Session::forget('oldUrl');
//            return redirect()->to($oldUrl);
//        }

        return redirect()->route('user.signin')->with('success', 'Проверьте почту!');
    }

    public function getSignin()
    {
        return view('user.signin');
    }

    public function postSignin(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'confirmed' => 1])) {
            if (Session::has('oldUrl')) {
                $oldUrl = Session::get('oldUrl');
                Session::forget('oldUrl');
                return redirect()->to($oldUrl);
            }
            return redirect()->route('user.profile');
        }
        return redirect()->back();
    }

    public function getProfile() {
        $orders = Auth::user()->orders;
        $orders->transform(function($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('user.profile', ['orders' => $orders]);
    }
    
    public function getLogout() {
        Auth::logout();
        return redirect()->route('user.signin');
    }

    public function confirm($confirmation_code)
    {
        if( !$confirmation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( !$user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();


        return redirect()->route('user.signin');
    }
}
