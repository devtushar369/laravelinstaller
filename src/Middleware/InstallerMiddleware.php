<?php


namespace Hashcode\laravelInstaller\Middleware;
use Closure;
use Illuminate\Http\Request;

class InstallerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
//        if (file_exists(storage_path('app/installed'))) {
//            return redirect('/');
//        }

        return $next($request);
    }
}
