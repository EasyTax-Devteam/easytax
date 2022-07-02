<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_forms', function (Blueprint $table) {
            $table->id();
            $table->string('service', 20);
            $table->string('field_label', 550)->nullable();
            $table->boolean('field_is_required')->default(true);
            $table->string('field_name', 100);
            $table->string('field_id', 100);
            $table->string('field_placeholder', 100)->nullable();
            $table->string('field_default_value')->nullable();
            $table->string('field_type', 55);
            $table->boolean('field_is_multiple')->default(false);
            $table->string('field_max_uploads', 3)->default(0);
            $table->text('field_options_json');
            $table->longText('field_form_code', 55);
            $table->string('order', 3)->default(1);
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
        Schema::dropIfExists('service_forms');
    }
}
