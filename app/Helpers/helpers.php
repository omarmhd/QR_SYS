<?php
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            return DB::table("settings")->where('key', $key)->value('value') ?? $default;
        });
    }

}
