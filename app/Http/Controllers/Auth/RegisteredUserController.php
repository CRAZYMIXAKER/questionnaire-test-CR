<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\User\PasswordMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{

    /**
     * Handle an incoming registration request.
     *
     */
    public function store(RegisterRequest $request): Response
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        broadcast(
            new UserUpdated([
                'name' => $user->name,
                'email' => $user->email,
            ])
        );

//        Mail::to($user->email)->send(new PasswordMail('asdasdasdasd'));

        return response()->noContent();
    }

}
