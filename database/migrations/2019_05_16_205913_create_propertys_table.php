<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propertys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->string('apartment');
            $table->double('apartment_coefficient')->default(0);
            $table->string('parking')->nullable();
            $table->double('parking_coefficient')->default(0);
            $table->string('useful_room')->nullable();
            $table->double('useful_room_coefficient')->default(0);
            $table->string('plates')->nullable();
            $table->string('pets')->nullable();
            $table->integer('extra_fee_state')->default(1);
            $table->integer('bill_state')->default(1);
            $table->double('fixed_fee')->nullable();
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
        Schema::dropIfExists('propertys');
    }
}
