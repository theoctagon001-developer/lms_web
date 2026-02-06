<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ApiConfig
{
    public static $apiBaseUrl; 
    public static function init()
    {
        if (!self::$apiBaseUrl) { 
            self::$apiBaseUrl = Cache::get('api_base_url', 'https://lms-backend-dqdn.onrender.com/'); 
        }
    }
    public static function setApiBaseUrl($url)
    {
        self::$apiBaseUrl = $url;
        Cache::forever('api_base_url', $url); 
    }

    public static function getApiBaseUrl()
    {
        return self::$apiBaseUrl;
    }
}
