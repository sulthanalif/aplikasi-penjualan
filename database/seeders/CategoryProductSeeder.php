<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryFood = Category::create(['name' => 'Makanan']);
        $categoryDrink = Category::create(['name' => 'Minuman']);

        $categoryFood->product()->createMany([
            [
                'name' => 'Ayam Geprek',
                'price' => 15000,
                'description' => 'Ayam geprek enak banget',
                // 'image' => 'ayamgeprek.jpg',
                'in_stock' => true,
            ],
            [
                'name' => 'Nasi Goreng',
                'price' => 20000,
                'description' => 'Nasi goreng enak banget',
                // 'image' => 'nasigoreng.jpg',
                'in_stock' => true,
            ],
            [
                'name' => 'Ayam Goreng',
                'price' => 15000,
                'description' => 'Ayam goreng enak banget',
                // 'image' => 'ayamgoreng.jpg',
                'in_stock' => true,
            ],
            [
                'name' => 'Nasi Gila',
                'price' => 20000,
                'description' => 'Nasi gila enak banget',
                'in_stock' => true,
            ],
        ]);

        $categoryDrink->product()->createMany([
            [
                'name' => 'Es Jeruk',
                'price' => 5000,
                'description' => 'Es jeruk enak banget',
                'in_stock' => true,
            ],
            [
                'name' => 'Es Campur',
                'price' => 5000,
                'description' => 'Es campur enak banget',
                'in_stock' => true,
            ],
        ]);
    }
}
