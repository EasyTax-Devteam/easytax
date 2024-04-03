<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxCalendarDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_calendar_days', function (Blueprint $table) {
            $table->id();
            $table->string('tax_calendar_id', 10);
            $table->string('day', 2);
            $table->string('holiday', 55)->nullable();
            $table->string('title', 55)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_calendar_days');
    }
}
