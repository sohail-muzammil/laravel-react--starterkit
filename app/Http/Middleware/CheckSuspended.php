<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isSuspended()) {
            // Customize the response based on suspension type
            $user = auth()->user();
            $message = 'Your account has been suspended.';

            if ($user->suspended_until) {
                $message .= ' Suspension ends in ' . $user->suspensionRemaining();
            } else {
                $message .= ' This suspension is indefinite.';
            }

            // For API requests
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'suspended_until' => $user->suspended_until,
                    'remaining' => $user->suspensionRemaining()
                ], 403);
            }

            // For web requests
            auth()->logout();
            return redirect()->route('login')->with('error', $message);
        }

        return $next($request);
    }
}
