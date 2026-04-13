<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    private string $baseUrl;
    private string $key;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.url');
        $this->key = config('services.external_api.key');
    }

    public function get(string $endpoint, array $params = [])
    {
        $params['key'] = $this->key;

        $response = Http::timeout(30)
            ->retry(5, 3000)
            ->get($this->baseUrl . $endpoint, $params);

        if (!$response->successful()) {
            throw new \Exception("API request failed: " . $response->body());
        }

        return $response->json();
    }

    public function getPaginated(string $endpoint, array $params = []): array
    {
        $page = 1;
        $allData = [];

        do {
            sleep(1);
            $params['page'] = $page;
            $params['limit'] = 500;

            $response = $this->get($endpoint, $params);

            $data = $response['data'] ?? [];

            $allData = array_merge($allData, $data);

            $this->logPage($endpoint, $page, count($data));

            $page++;
            $hasMore = count($data) === 500;

        } while ($hasMore);

        return $allData;
    }

    private function logPage(string $endpoint, int $page, int $count): void
    {
        logger()->info("API pagination", [
            'endpoint' => $endpoint,
            'page' => $page,
            'count' => $count,
        ]);
    }
}
