<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserUpdated;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request
    ): RedirectResponse {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url').RouteServiceProvider::HOME
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            $this->userService::sendUserBroadcast($request->user());
        }

        return redirect()->intended(
            config('app.frontend_url').RouteServiceProvider::HOME
        );
    }
}
