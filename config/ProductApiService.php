<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductApiService
{
    private $apiUrl = 'https://fakestoreapi.com/products';

    public function fetchAndStoreProducts()
    {
        try {
            $response = Http::timeout(30)->get($this->apiUrl);
            
            if ($response->failed()) {
                throw new \Exception('Failed to fetch products from API');
            }

            $products = $response->json();
            $result = ['saved' => 0, 'updated' => 0, 'errors' => []];

            foreach ($products as $productData) {
                try {
                    $this->storeProduct($productData);
                    
                    $existingProduct = Product::where('external_id', $productData['id'])->first();
                    if ($existingProduct->wasRecentlyCreated) {
                        $result['saved']++;
                    } else {
                        $result['updated']++;
                    }
                } catch (\Exception $e) {
                    $result['errors'][] = "Error processing product {$productData['id']}: " . $e->getMessage();
                    Log::error("Error processing product {$productData['id']}: " . $e->getMessage());
                }
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Product API fetch error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function storeProduct($productData)
    {
        return Product::updateOrCreate(
            ['external_id' => $productData['id']],
            [
                'title' => $productData['title'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'category_id' => $productData['category']['id'] ?? null,
                'category_name' => $productData['category']['name'] ?? null,
                'images' => $productData['images'] ?? [],
            ]
        );
    }

    public function syncProducts()
    {
        return $this->fetchAndStoreProducts();
    }
}