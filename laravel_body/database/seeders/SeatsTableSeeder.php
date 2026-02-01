<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table('seats')->truncate();

        // 初期データ用意
        $seats = [
            [
                'seatType' => 'counter',
                'remainingSeats' => 10,
                'maxGuestsPerSeat' => 1,
            ],
            [
                'seatType' => 'tableSeat',
                'remainingSeats' => 5,
                'maxGuestsPerSeat' => 4,
            ],
            [
                'seatType' => 'tatamiRoom',
                'remainingSeats' => 3,
                'maxGuestsPerSeat' => 6,
            ]
        ];

        // 登録
        foreach ($seats as $seat) {
            \App\Models\Seat::create($seat);
        }
    }
}
