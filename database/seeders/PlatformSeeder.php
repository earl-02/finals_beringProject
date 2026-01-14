<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            ['name'=>'PlayStation 5','manufacturer'=>'Sony'],
            ['name'=>'Xbox Series X','manufacturer'=>'Microsoft'],
            ['name'=>'Nintendo Switch','manufacturer'=>'Nintendo'],
            ['name'=>'PC','manufacturer'=>null],
            ['name'=>'PlayStation 4','manufacturer'=>'Sony'],
        ];

        foreach ($platforms as $p) {
            Platform::firstOrCreate(['name'=>$p['name']], ['manufacturer'=>$p['manufacturer']]);
        }
    }
}
