<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HttpService
{
    /**
     * Default timeout for API calls (120 seconds for slow backend)
     */
    const DEFAULT_TIMEOUT = 120;

    /**
     * Make an HTTP GET request with extended timeout
     */
    public static function get(string $url, array $query = [])
    {
        return Http::timeout(self::DEFAULT_TIMEOUT)->get($url, $query);
    }

    /**
     * Make an HTTP POST request with extended timeout
     */
    public static function post(string $url, array $data = [])
    {
        return Http::timeout(self::DEFAULT_TIMEOUT)->post($url, $data);
    }

    /**
     * Make an HTTP PUT request with extended timeout
     */
    public static function put(string $url, array $data = [])
    {
        return Http::timeout(self::DEFAULT_TIMEOUT)->put($url, $data);
    }

    /**
     * Make an HTTP DELETE request with extended timeout
     */
    public static function delete(string $url, array $data = [])
    {
        return Http::timeout(self::DEFAULT_TIMEOUT)->delete($url, $data);
    }

    /**
     * Make an HTTP PATCH request with extended timeout
     */
    public static function patch(string $url, array $data = [])
    {
        return Http::timeout(self::DEFAULT_TIMEOUT)->patch($url, $data);
    }
}
