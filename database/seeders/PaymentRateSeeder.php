<?php

namespace Database\Seeders;

use App\Models\PaymentRate;
use Illuminate\Database\Seeder;

class PaymentRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentRate::create(['nominal' => 1_000_000]);
    }
}
