<?php

namespace Database\Seeders;

use App\Models\TrackLabTest;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabTrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     lab_order_id`, `expected_result_released_date`, `status`, `delivered_at`, `result`, `result_released_at`, `notes`
     */
    public function run(): void
    {
        TrackLabTest::upsert([
            [
               'lab_order_id'=>1,
                'expected_result_released_date' =>'2024-01-01',
                'delivered_at' =>'2024-02-02',
                'result_released_at'=>'2024-03-03',
                'notes'=>'notes1',
                
            ],
            [
               'lab_order_id'=>2,
                'expected_result_released_date' =>'2024-01-02',
                'delivered_at' =>'2024-02-03',
                'result_released_at'=>'2024-03-04',
                'notes'=>'notes1',
              

            ],
            [
               'lab_order_id'=>3,
                'expected_result_released_date' =>'2024-01-03',
                'delivered_at' =>'2024-02-04',
                'result_released_at'=>'2024-03-05',
                'notes'=>'notes1',

            ],
            [
               'lab_order_id'=>4,
                'expected_result_released_date' =>'2024-01-04',
                'delivered_at' =>'2024-02-05',
                'result_released_at'=>'2024-03-06',
                'notes'=>'notes1',
              

            ],
            [
               'lab_order_id'=>5,
                'expected_result_released_date' =>'2024-01-05',
                'delivered_at' =>'2024-02-06',
                'result_released_at'=>'2024-03-07',
                'notes'=>'notes1',
              

            ],
            [
               'lab_order_id'=>6,
                'expected_result_released_date' =>'2024-01-06',
                'delivered_at' =>'2024-02-07',
                'result_released_at'=>'2024-03-08',
                'notes'=>'notes1',
              

            ],
            [
               'lab_order_id'=>7,
                'expected_result_released_date' =>'2024-01-07',
                'delivered_at' =>'2024-02-08',
                'result_released_at'=>'2024-03-09',
                'notes'=>'notes1',
             


            ],
        ],
        ['lab_order_id','expected_result_released_date', 'delivered_at', 'result_released_at','notes']);
    }
}
