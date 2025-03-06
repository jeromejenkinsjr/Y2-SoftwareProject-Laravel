<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShopItem;
class ShopItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ShopItem::create([
            'name'        => 'Exclusive GIF Rights',
            'description' => 'Purchase the rights to use this cool GIF in your profile.',
            'price'       => 1, // 1 credit
            'image'       => 'images/shopitem1.gif', // Path relative to public/
        ]);

        ShopItem::create([
            'name'        => 'Exclusive GIF Rights 2',
            'description' => 'Purchase the rights to use this amazing GIF.',
            'price'       => 1, // Price in credits
            'image'       => 'images/shopitem2.gif',
        ]);

        ShopItem::create([
            'name'        => 'Exclusive GIF Rights 3',
            'description' => 'Purchase the rights to use this awesome GIF.',
            'price'       => 1, // Price in credits
            'image'       => 'images/shopitem3.gif',
        ]);
    }
}
