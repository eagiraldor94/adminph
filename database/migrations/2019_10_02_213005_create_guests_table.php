<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('propertys')->onDelete('cascade');
            $table->string('auth_name');
            $table->string('name');
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('photo')->nullable();
            $table->string('id_photo')->nullable();
            $table->date('date');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->string('observations');
            $table->string('authorizer')->nullable();
            $table->integer('authorized')->default(0);
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
        Schema::dropIfExists('guests');
    }
}
