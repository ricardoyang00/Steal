<?php

if (!function_exists('auth_user')) {
    function auth_user() {
        if (Auth::check()) {
            return Auth::user();
        } elseif (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user();
        }
        return null;
    }
}

if (!function_exists('is_admin')) {
    function is_admin() {
        return Auth::guard('admin')->check();
    }
}