<?php

namespace App\Http\Controllers;
use App\Services\ApiConfig;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getApiUrl()
    {
        ApiConfig::init();
        return response()->json([
            'api_base_url' => ApiConfig::getApiBaseUrl()
        ]);
    }
    public function updateApiUrl(Request $request)
    {
        $url = $request->query('url'); 
        if (!$url) {
            return response()->json(['error' => 'API Base URL is required'], 400);
        }

        ApiConfig::setApiBaseUrl($url);

        return response()->json([
            'message' => 'API Base URL updated successfully!',
            'api_base_url' => ApiConfig::getApiBaseUrl()
        ]);
    }
}
