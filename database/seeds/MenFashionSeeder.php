<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenFashionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Download and Create Category
        $catImg = $this->downloadImage('https://images.unsplash.com/photo-1598033129183-c4f50c736f10?w=500&q=80', 'category');
        $category = Category::create([
            'name' => 'Men Shirts',
            'slug' => 'men-shirts-' . Str::random(3),
            'icon' => $catImg,
            'parent_id' => 0,
            'position' => 0,
            'home_status' => 1,
            'priority' => 1
        ]);

        // 2. Download and Create Brand
        $brandImg = $this->downloadImage('https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?w=500&q=80', 'brand');
        $brand = Brand::create([
            'name' => 'Zara Men',
            'image' => $brandImg,
            'status' => 1
        ]);

        // 3. Download and Create Product
        $prodThumb = $this->downloadImage('https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500&q=80', 'product/thumbnail');
        $prodImg1 = $this->downloadImage('https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80', 'product');

        $product = Product::create([
            'added_by' => 'admin',
            'user_id' => 0,
            'name' => 'Classic Men Shirt',
            'slug' => 'classic-men-shirt-' . Str::random(5),
            'category_ids' => json_encode([['id' => (string)$category->id, 'position' => 1]]),
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'unit' => 'pc',
            'product_type' => 'physical',
            'details' => 'A classic men shirt perfect for formal and casual wear.',
            'colors' => json_encode([]),
            'choice_options' => json_encode([]),
            'variation' => json_encode([]),
            'unit_price' => 500,
            'purchase_price' => 300,
            'tax' => 0,
            'tax_type' => 'percent',
            'tax_model' => 'exclude',
            'discount' => 0,
            'discount_type' => 'flat',
            'attributes' => json_encode([]),
            'current_stock' => 100,
            'minimum_order_qty' => 1,
            'status' => 1,
            'request_status' => 1,
            'featured_status' => 1,
            'thumbnail' => $prodThumb,
            'images' => json_encode([['image_name' => $prodImg1, 'storage' => 'public']]),
        ]);

        $this->command->info('Men Fashion Seeder completed successfully!');
    }

    /**
     * Download image from URL and save it to storage.
     */
    private function downloadImage($url, $folder)
    {
        try {
            // Using basic context options to avoid SSL errors sometimes found in local environments
            $context = stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ],
                "http" => [
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
                ]
            ]);
            $contents = file_get_contents($url, false, $context);
            if ($contents) {
                $filename = Str::random(15) . '.jpg';
                Storage::disk('public')->put($folder . '/' . $filename, $contents);
                return $filename;
            }
        } catch (\Exception $e) {
            // Log error if needed, returning default
        }
        return 'def.png';
    }
}
