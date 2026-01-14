<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Platform;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['title'=>'Horizon Forbidden West','release_year'=>2022,'price'=>1999.00,'platform'=>'PlayStation 5'],
            ['title'=>'Forza Horizon 5','release_year'=>2021,'price'=>2499.50,'platform'=>'Xbox Series X'],
            ['title'=>'Zelda: Breath of the Wild','release_year'=>2017,'price'=>2999.00,'platform'=>'Nintendo Switch'],
            ['title'=>'Cyberpunk 2077','release_year'=>2020,'price'=>1499.99,'platform'=>'PC'],
            ['title'=>'Spider-Man','release_year'=>2018,'price'=>1299.75,'platform'=>'PlayStation 4'],
        ];

        foreach ($data as $g) {
            $platform = Platform::where('name', $g['platform'])->first();
            Game::firstOrCreate(
                ['title'=>$g['title']],
                ['release_year'=>$g['release_year'],'price'=>$g['price'],'platform_id'=>$platform->id ?? null]
            );
        }
    }
}
