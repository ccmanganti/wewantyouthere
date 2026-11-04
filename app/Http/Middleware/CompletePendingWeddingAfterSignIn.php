<?php

namespace App\Http\Middleware;

use App\Http\Controllers\WeddingBuilderController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompletePendingWeddingAfterSignIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()
            && $request->session()->has('pending_wedding')
            && ! $request->session()->has('pending_wedding_attempted')) {
            // Mark before redirecting to avoid a loop when publication is rejected.
            $request->session()->put('pending_wedding_attempted', true);

            return app(WeddingBuilderController::class)->complete($request);
        }

        return $next($request);
    }
}
