<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    public function __construct(private readonly UserService $userService) {}

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        $this->userService::sendUserBroadcast(
            $this->userService::getUserByEmail($request->validated('email'))
        );

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->userService::sendUserBroadcast(null);

        return response()->noContent();
    }

}
