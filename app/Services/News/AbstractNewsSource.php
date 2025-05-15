<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class AbstractNewsSource implements NewsSourceInterface
{
    protected string $baseUrl;

    protected string $sourceName;

    /**
     * Make an HTTP request to the news source API
     */
    protected function makeRequest(string $endpoint, array $params = []): ?array
    {
        try {
            $response = Http::get($this->baseUrl.$endpoint, $params);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("Failed to fetch news from {$this->sourceName}", [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error("Exception while fetching news from {$this->sourceName}", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    /**
     * Get the base URL of the news source
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Get the name of the news source
     */
    public function getSourceName(): string
    {
        return $this->sourceName;
    }
}
