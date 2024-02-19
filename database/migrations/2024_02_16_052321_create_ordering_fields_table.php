<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderingFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordering_fields', function (Blueprint $table) {
            $table->id();
            $table->string('ordering_col')->default('order');
            $table->string('ordering_dir', 10)->default('asc');
            $table->string('target');
            $table->timestamps();
        });

        DB::table('ordering_fields')->insert([
            ['ordering_col' => 'order', 'ordering_dir' => 'asc', 'target' => 'JOB'],
            ['ordering_col' => 'order', 'ordering_dir' => 'asc', 'target' => 'SLIDER'],
            ['ordering_col' => 'order', 'ordering_dir' => 'asc', 'target' => 'BLOG'],
            ['ordering_col' => 'order', 'ordering_dir' => 'asc', 'target' => 'CATEGORY'],
            ['ordering_col' => 'order', 'ordering_dir' => 'asc', 'target' => 'SERVICE'],
            ['ordering_col' => 'order', 'ordering_dir' => 'asc', 'target' => 'SERVICE_CATEGORY'],
            ['ordering_col' => 'order', 'ordering_dir' => 'asc', 'target' => 'TEAM'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordering_fields');
    }
}
