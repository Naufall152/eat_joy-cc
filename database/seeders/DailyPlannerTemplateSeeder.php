<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyPlannerTemplate;

class DailyPlannerTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Starter (contoh default 5)
        $starter = [
            ['plan'=>'starter','task'=>'Sarapan Sehat','time'=>'07:00','calories'=>350,'is_default'=>true],
            ['plan'=>'starter','task'=>'Snack Buah','time'=>'10:00','calories'=>120,'is_default'=>true],
            ['plan'=>'starter','task'=>'Makan Siang','time'=>'12:30','calories'=>450,'is_default'=>true],
            ['plan'=>'starter','task'=>'Workout Ringan','time'=>'16:30','calories'=>200,'is_default'=>true],
            ['plan'=>'starter','task'=>'Makan Malam','time'=>'19:00','calories'=>400,'is_default'=>true],
        ];

        // Starter+ (contoh default 3)
        $starterPlus = [
            ['plan'=>'starter_plus','task'=>'Workout + Stretching','time'=>'06:30','calories'=>250,'is_default'=>true],
            ['plan'=>'starter_plus','task'=>'Makan Siang Premium','time'=>'12:30','calories'=>500,'is_default'=>true],
            ['plan'=>'starter_plus','task'=>'AI Check-in Diet','time'=>'20:30','calories'=>0,'is_default'=>true],
        ];

        DailyPlannerTemplate::insert(array_merge($starter, $starterPlus));
    }
}
