<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getAuthenticatedUser')) {
    function getAuthenticatedUser()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user();
        } elseif (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }

        return null;
    }
}
?>