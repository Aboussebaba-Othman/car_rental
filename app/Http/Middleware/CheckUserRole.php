<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;



class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        switch ($role) {
            case 'admin':
                if (!$user->isAdmin()) {
                    abort(403, 'Unauthorized action.');
                }
                break;
            case 'company':
                if (!$user->isCompany()) {
                    abort(403, 'Unauthorized action.');
                }
                break;
            case 'user':
                if (!$user->isUser()) {
                    abort(403, 'Unauthorized action.');
                }
                break;
            default:
                abort(403, 'Unauthorized action.');
                break;
        }

        return $next($request);
    }
}