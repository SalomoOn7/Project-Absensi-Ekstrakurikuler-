<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public const HOME = '/dashboard';
    public static function  redirectTo(){
        $role = Auth::user()->role;
        return match($role){
        'super_admin' => '/superadmin/dashboard',
        'admin' => '/admin/dashboard',
        'petugas' => '/petugas/dashboard',
        default => '/dashboard',
        };
    }
}
