<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Create2025TaxCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        $now = new DateTime();

        $iter = 1;
        $data_array = [];
        while($iter <= 13){
            $year = intval($now->format('Y'));
            $month = $iter > 9 ? $iter : '0'.$iter;
            if($iter > 12){
                $year++;
                $month = '01';
            }
            if($iter <= 12 && $month == '01'){
                continue;
            }
            $file_path = config('app.url') . 'artwork/services/calendar.webp';
            $data = [
                'id' => $iter,
                'year' => $year,
                'month' => $month,
                'title' => 'EasyTax Kenya Tax Calendar',
                'theme' => '#ed2425',
                'art_work' => $file_path,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s')
            ];
            array_push($data_array, $data);
            $iter ++;
        }
        logger("now installing seed calendar data ", $data_array);
        DB::table('tax_calendars')->insert($data_array);
        DB::table('tax_calendars')->where('year', $year - 1)->update(['is_active' => 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
