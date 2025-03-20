<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopItem;

class ShopItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // GIFs
        $shopItems = [
            [
                'name'        => 'Exclusive GIF Rights',
                'description' => 'Purchase the rights to use this cool GIF in your profile.',
                'price'       => 1,
                'image'       => 'images/shopitem1.gif',
                'type'        => 'item',
            ],
            [
                'name'        => 'Exclusive GIF Rights 2',
                'description' => 'Purchase the rights to use this amazing GIF.',
                'price'       => 1,
                'image'       => 'images/shopitem2.gif',
                'type'        => 'item',
            ],
            [
                'name'        => 'Exclusive GIF Rights 3',
                'description' => 'Purchase the rights to use this awesome GIF.',
                'price'       => 1,
                'image'       => 'images/shopitem3.gif',
                'type'        => 'item',
            ],
        ];

        // Icon Shop Items
        $iconItems = [
            ['name' => 'LL Icon', 'image' => 'icons/ll-icon.png', 'price' => 100, 'type' => 'icon'],
            ['name' => 'Cat', 'image' => 'icons/cat.png', 'price' => 120, 'type' => 'icon'],
            ['name' => 'Chick', 'image' => 'icons/chick.png', 'price' => 80, 'type' => 'icon'],
            ['name' => 'Diamond', 'image' => 'icons/diamond.png', 'price' => 200, 'type' => 'icon'],
            ['name' => 'Dragon', 'image' => 'icons/dragon.png', 'price' => 250, 'type' => 'icon'],
            ['name' => 'Flame', 'image' => 'icons/flame.png', 'price' => 90, 'type' => 'icon'],
            ['name' => 'Lion', 'image' => 'icons/lion.png', 'price' => 110, 'type' => 'icon'],
            ['name' => 'Mask', 'image' => 'icons/mask.png', 'price' => 130, 'type' => 'icon'],
        ];

        // Insert all items into the ShopItem table
        foreach (array_merge($shopItems, $iconItems) as $item) {
            ShopItem::create($item);
        }
    }
}