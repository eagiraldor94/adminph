<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('propertys')->onDelete('cascade');
            $table->string('name');
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('photo');
            $table->string('receiver');
            $table->string('claimer')->nullable();
            $table->string('claimer_id_type')->nullable();
            $table->string('claimer_id_number')->nullable();
            $table->string('delieverer')->nullable();
            $table->datetime('deliever_date')->nullable();
            $table->string('observations');
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
        Schema::dropIfExists('packages');
    }
}
