<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**q
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('propertys')->onDelete('cascade');
            $table->double('balance');
            $table->double('first_concept');
            $table->double('second_concept');
            $table->double('third_concept');
            $table->double('discount');
            $table->double('fourth_concept');
            $table->double('fifth_concept');
            $table->double('sixth_concept');
            $table->double('seventh_concept');
            $table->double('eighth_concept');
            $table->double('nineth_concept');
            $table->double('tenth_concept');
            $table->double('first_balance')->default(0);
            $table->double('second_balance')->default(0);
            $table->double('third_balance')->default(0);
            $table->double('fourth_balance')->default(0);
            $table->double('fifth_balance')->default(0);
            $table->double('sixth_balance')->default(0);
            $table->double('seventh_balance')->default(0);
            $table->double('eighth_balance')->default(0);
            $table->double('nineth_balance')->default(0);
            $table->double('tenth_balance')->default(0);
            $table->integer('applied')->default(0);
            $table->double('total');
            $table->date('discount_date');
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
        Schema::dropIfExists('bills');
    }
}
