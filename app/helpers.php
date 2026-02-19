<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get a company setting value.
     * setting('company_name') or setting('company_name', 'Default')
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('logo_url')) {
    /**
     * Return the URL for the company logo.
     * Falls back to /logo.png if none has been uploaded.
     */
    function logo_url(): string
    {
        $stored = Setting::get('company_logo');
        if ($stored && file_exists(public_path($stored))) {
            return asset($stored);
        }
        return asset('logo.png');
    }
}
