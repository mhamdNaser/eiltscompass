<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paypal;

class PaypalTableSeeder extends Seeder
{
    public function run(): void
    {
        Paypal::create([
            'clientId' => 'default_value',
            'secret' => 'default_value',
            'MonSub' => 0,
        ]);
    }
}
