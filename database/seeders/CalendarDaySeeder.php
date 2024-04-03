<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $caledars = DB::table('tax_calendars')->select(['*'])->get()->toArray();
        $data_array = [];

        foreach( $caledars as $month):
            $days_in_this_month = cal_days_in_month(CAL_GREGORIAN, intval($month->month), intval($month->year));
            $iter = 0;
            $dt = \DateTime::createFromFormat('!m', $month->month);
            $month_name = $dt->format('F');
            while($iter < $days_in_this_month){

                $day_val = $iter + 1;
                $holiday = $this->getHoliday($day_val, intval(($month->month)));
                $day = $day_val > 9 ? $day_val : '0'.$day_val;
                $title = $day . ' ' . $month_name . ' ' . $month->year;
                $data = [
                    'tax_calendar_id' => $month->id,
                    'day' => $day,
                    'holiday' => $holiday,
                    'title' => $title,
                    'description' => null,
                ];
                array_push($data_array, $data);
                $iter ++;
            }
        endforeach;
        logger("now installing seed days data ", $data_array);
        DB::table('tax_calendar_days')->insert($data_array);
    }

    protected function getHoliday($day, $month){
        if($day == 1 && $month == 1 ){
            return "New Year's Day";
        }
        if($day == 1 && $month == 5 ){
            return "Labour Day";
        }
        if($day == 1 && $month == 6 ){
            return "Madaraka Day";
        }
        if($day == 20 && $month == 10 ){
            return "Mashujaa Day";
        }
        if($day == 12 && $month == 12 ){
            return "Jamhuri Day";
        }
        if($day == 25 && $month == 12 ){
            return "Christmas Day";
        }
        if($day == 26 && $month == 12 ){
            return "Boxing Day";
        }
        return null;
    }
}
