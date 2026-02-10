<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\School;

class CheckSchoolActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Check if the user is authenticated with the specified guard
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            // Check if user belongs to a school
            if ($user && !empty($user->school_id)) {
                
                // Allow SuperAdmins to bypass this check (only for admin guard)
                if ($guard === 'admin' && isset($user->role) && $user->role === 'superadmin') {
                    return $next($request);
                }

                // Fetch the school
                $school = School::find($user->school_id);

                // Check if school is inactive or deactivated
                if ($school && ($school->status === 'inactive' || $school->is_active == 0)) {
                    
                    // Log the user out
                    Auth::guard($guard)->logout();
                    
                    // Invalidate the session
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    // Determine redirect route based on guard
                    $route = $guard === 'admin' ? 'admin.login' : 'student.login';
                    
                    return redirect()->route($route)->withErrors([
                        'email' => 'Your school is deactivated. Contact to management team'
                    ]);
                }
            }
        }

        return $next($request);
    }
}
