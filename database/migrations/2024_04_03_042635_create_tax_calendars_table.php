<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTaxCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('tax_calendars', function (Blueprint $table) {
            $now = new DateTime();
            $table->id();
            $table->smallInteger('year')->default(intval($now->format('Y')));
            $table->string('month')->default($now->format('m'));
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('theme')->nullable();
            $table->string('art_work')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_calendars');
    }
}
