<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Icon;

class IconSeeder extends Seeder {
    public function run() {
        $icons = [
            ['name' => 'LL Icon', 'path' => 'icons/ll-icon.png'],
            ['name' => 'Cat', 'path' => 'icons/cat.png'],
            ['name' => 'chick', 'path' => 'icons/chick.png'],
            ['name' => 'diamond', 'path' => 'icons/diamond.png'],
            ['name' => 'dragon', 'path' => 'icons/dragon.png'],
            ['name' => 'flame', 'path' => 'icons/flame.png'],
            ['name' => 'lion', 'path' => 'icons/lion.png'],
            ['name' => 'mask', 'path' => 'icons/mask.png'],
        ];

        foreach ($icons as $icon) {
            Icon::create($icon);
        }
    }
}