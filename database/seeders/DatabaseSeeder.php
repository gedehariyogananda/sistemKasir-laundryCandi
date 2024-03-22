<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PaymentMethod;
use App\Models\Spesification;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Spesification::create([
            'spesifikasi_cuci' => 'Cuci Kering',
            'hargakilo' => '15000',
        ]);

        Spesification::create([
            'spesifikasi_cuci' => 'Cuci Basah',
            'hargakilo' => '10000',
        ]);

        Spesification::create([
            'spesifikasi_cuci' => 'Cuci Setrika',
            'hargakilo' => '20000',
        ]);

        Spesification::create([
            'spesifikasi_cuci' => 'Setrika aja',
            'hargakilo' => '8000',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'BCA',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'BNI',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'BRI',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'Mandiri',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'OVO',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'Gopay',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'Dana',
        ]);

        PaymentMethod::create([
            'payment_method_name' => 'Link Aja',
        ]);
    }
}
