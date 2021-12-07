<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('pin');
            $table->string('itax_password');
            $table->string('has_taxable_income');
            $table->string('paying_kenyan_insurance_policies')->nullable();
            $table->text('kenyan_insurance_policies_paid')->nullable();
            $table->string('paid_mortgage_for_tax_year')->nullable();
            $table->text('p_nine_form')->nullable();
            $table->text('income_and_expenses_schedule')->nullable();
            $table->text('financial_statements')->nullable();
            $table->string('service');
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
        Schema::dropIfExists('orders');
    }
}
