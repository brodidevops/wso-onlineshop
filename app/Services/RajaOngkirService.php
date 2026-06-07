<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RajaOngkirService
{
    protected string $apiKey;
    protected string $originCityId;
    protected string $baseUrl = 'https://api.rajaongkir.com/starter';

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->originCityId = config('rajaongkir.origin_city_id', '501');
    }

    /**
     * Get all provinces.
     *
     * @return array
     */
    public function getProvinces(): array
    {
        return Cache::remember('rajaongkir_provinces', now()->addHours(6), function () {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/province");

            if ($response->successful()) {
                $results = $response->json('rajaongkir.results') ?? [];
                return $results;
            }

            return [];
        });
    }

    /**
     * Get cities by province ID.
     *
     * @param int|null $provinceId
     * @return array
     */
    public function getCities(?int $provinceId = null): array
    {
        $cacheKey = $provinceId ? "rajaongkir_cities_province_{$provinceId}" : 'rajaongkir_cities_all';

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($provinceId) {
            $params = [];
            if ($provinceId) {
                $params['province'] = $provinceId;
            }

            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/city", $params);

            if ($response->successful()) {
                return $response->json('rajaongkir.results') ?? [];
            }

            return [];
        });
    }

    /**
     * Calculate shipping cost.
     *
     * @param string $destinationCityId
     * @param int $weight Weight in grams
     * @param string $courier Courier code (jne, pos, tiki)
     * @return array
     */
    public function getShippingCost(string $destinationCityId, int $weight, string $courier): array
    {
        try {
            $response = Http::timeout(10)->withHeaders([
                'key' => $this->apiKey,
            ])->post("{$this->baseUrl}/cost", [
                'origin' => $this->originCityId,
                'destination' => $destinationCityId,
                'weight' => $weight,
                'courier' => strtolower($courier),
            ]);

            if ($response->successful()) {
                $results = $response->json('rajaongkir.results') ?? [];
                return $results;
            }

            \Log::warning('RajaOngkir API failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [];
        } catch (\Exception $e) {
            \Log::error('RajaOngkir API exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get available couriers.
     *
     * @return array
     */
    public function getCouriers(): array
    {
        return config('rajaongkir.couriers', []);
    }

    /**
     * Get service names for a courier.
     *
     * @param string $courier
     * @return array
     */
    public function getServiceNames(string $courier): array
    {
        return config("rajaongkir.services.{$courier}", []);
    }
}