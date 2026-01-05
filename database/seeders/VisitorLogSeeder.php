<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitorLogSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('visitor_logs')->insert([
                'path' => '/admin/visitors',
                'ip' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'visited_date' => now()->subDays(rand(0, 13))->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
