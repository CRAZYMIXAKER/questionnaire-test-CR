<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class UpdateSurveySession
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $this->updateSessionCookie($response);
        }

        return $response;
    }

    /**
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     *
     * @return void
     */
    private function updateSessionCookie(Response &$response): void
    {
        $surveySession = request()->cookie('survey_session');

        if (!$surveySession) {
            $newSession = Uuid::uuid4()->toString();
            $cookie = cookie('survey_session', $newSession, 7 * 24 * 60);
            $response->headers->setCookie($cookie);
        }
    }

}
