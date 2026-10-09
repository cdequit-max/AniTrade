<?php

namespace Database\Seeders;

use App\Models\Produce;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Demo data. All demo accounts use the password: password */
    public function run(): void
    {
        User::create(['name' => 'Maria Santos', 'email' => 'buyer@anitrade.com', 'role' => 'buyer', 'password' => 'password']);

        $stores = [
            ['Juan Dela Cruz', "Juan's Farm Store", 'store@anitrade.com', [
                ['Fresh Tomatoes', 'Vegetables', 80, 'kg', 120],
                ['Eggplant', 'Vegetables', 60, 'kg', 5],
            ]],
            ['Pedro Reyes', "Pedro's Rice Store", 'pedro@anitrade.com', [
                ['Lowland Rice', 'Grains', 55, 'kg', 500],
                ['Fresh Tomatoes', 'Vegetables', 75, 'kg', 60],
            ]],
            ['Ana Lopez', "Ana's Fruit Stand", 'ana@anitrade.com', [
                ['Bananas (Lakatan)', 'Fruits', 60, 'kg', 200],
                ['Mango (Carabao)', 'Fruits', 90, 'kg', 80],
            ]],
        ];

        foreach ($stores as [$name, $storeName, $email, $items]) {
            $store = User::create(['name' => $name, 'store_name' => $storeName, 'email' => $email, 'role' => 'store', 'password' => 'password']);

            foreach ($items as [$produce, $category, $price, $unit, $stock]) {
                Produce::create([
                    'store_id' => $store->id, 'name' => $produce, 'category' => $category,
                    'price' => $price, 'unit' => $unit, 'stock' => $stock,
                ]);
            }
        }
    }
}
