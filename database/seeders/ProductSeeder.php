<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Client;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id')->toArray();
        $clients = Client::pluck('id')->toArray();

        if (empty($categories) || empty($clients)) {
            $this->command->warn("Make sure categories and clients are seeded before seeding products.");
            return;
        }

        // Create 5 more products based on the store() method structure
        for ($i = 21; $i <= 25; $i++) {
            $name = 'Custom Product ' . $i;
            $slug = Str::slug($name . '-' . Str::random(5));

            Product::create([
                'category_id' => $categories[array_rand($categories)],
                'client_id' => $clients[array_rand($clients)],
                'name' => $name,
                'slug' => $slug,
                'description' => 'Custom seeded product description for ' . $name,
                'price' => rand(200, 1200),
                'discount_price' => rand(50, 199),
                'product_code' => strtoupper(Str::random(10)),
                'thumbnail_image' => 'uploads/product/thumbnails/thumbnail_' . $i . '.jpg',
                'gallery_images' => json_encode([
                    'uploads/product/gallery/gallery_' . $i . '_1.jpg',
                    'uploads/product/gallery/gallery_' . $i . '_2.jpg',
                ]),
                'sizes' => json_encode(['S', 'M', 'L']),
                'colors' => json_encode(['Red', 'Blue', 'Black']),
                'is_featured' => rand(0, 1) ? 'Yes' : 'No',
                'is_top_selling' => rand(0, 1) ? 'Yes' : 'No',
                'is_popular' => rand(0, 1) ? 'Yes' : 'No',
                'is_special' => rand(0, 1) ? 'Yes' : 'No',
                'is_best' => rand(0, 1) ? 'Yes' : 'No',
                'is_new' => rand(0, 1) ? 'Yes' : 'No',
                'ip_address' => '127.0.0.1',
                'status' => 'a',
            ]);
        }
    }
}