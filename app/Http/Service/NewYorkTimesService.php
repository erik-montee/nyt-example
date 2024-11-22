<?php

namespace App\Http\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class NewYorkTimesService 
{
    protected $baseUrl;
    protected $apiKey;
    
    public function __construct()
    {
        $this->baseUrl = config('services.nyt.base_url');
        $this->apiKey = config('services.nyt.api_key');
    }

    public function getBestSellersFromInput($data)
    {
        $url = "/svc/books/v3/lists/best-sellers/history.json";
        return $this->getNewYorkTimesAPI($url, $data);
    }

    private function getNewYorkTimesAPI($url, $data = []) 
    {
        $data['api-key'] = $this->apiKey;
        try {
            $response = Http::connectTimeout(1)->timeout(1)->get($this->baseUrl . $url, $data);
            if ($response->ok()) {
                return $response->json();
            } elseif ($response->unauthorized()) {
                return response()->json($response->json(), 401);
            }
        } 
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => "Error in Service"], 500);
        }

    }
}