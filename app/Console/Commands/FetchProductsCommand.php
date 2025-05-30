<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch products from API and save/update in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching products from API...');

        try {
            $response = Http::timeout(30)->get('https://api.escuelajs.co/api/v1/products');
            
            if ($response->failed()) {
                $this->error('Failed to fetch products from API');
                return 1;
            }

            $products = $response->json();
            $savedCount = 0;
            $updatedCount = 0;

            foreach ($products as $productData) {
                // Skip if essential data is missing
                if (!isset($productData['id']) || !isset($productData['title'])) {
                    continue;
                }

                // Get category safely with proper null checks
                $category = $productData['category'] ?? null;
                $categoryName = null;

                if ($category && is_array($category)) {
                    $categoryName = $category['name'] ?? null;
                }

                // Check if product already exists by external ID
                $existingProduct = Product::where('external_id', $productData['id'])->first();

                $productInfo = [
                    'external_id' => $productData['id'],
                    'title' => $productData['title'] ?? 'Untitled Product',
                    'description' => $productData['description'] ?? '',
                    'price' => isset($productData['price']) ? (float)$productData['price'] : 0.00,
                    'category_id' => null, // Set to null to avoid foreign key constraint
                    'category_name' => $categoryName,
                    'images' => json_encode($productData['images'] ?? []),
                    'updated_at' => now(),
                ];

                if ($existingProduct) {
                    $existingProduct->update($productInfo);
                    $updatedCount++;
                } else {
                    $productInfo['created_at'] = now();
                    Product::create($productInfo);
                    $savedCount++;
                }
            }

            $this->info("Successfully processed products:");
            $this->info("- New products saved: {$savedCount}");
            $this->info("- Existing products updated: {$updatedCount}");

        } catch (\Exception $e) {
            $this->error('Error fetching products: ' . $e->getMessage());
            Log::error('Product fetch error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}