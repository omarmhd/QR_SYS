<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || is_null($user->current_subscription)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your subscription has expired or is inactive.'
            ], 403);
        }

        if (now()->greaterThan($user->subscription->end_date)) {
            $user->subscription->update(['status' => 'expired']);

            return response()->json([
                'status' => 'error',
                'message' => 'Your subscription has expired.'
            ], 403);
        }

        return $next($request);    }
}
