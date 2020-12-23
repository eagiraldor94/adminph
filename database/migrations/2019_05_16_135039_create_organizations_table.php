<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('NIT');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->double('discount')->default(0);
            $table->integer('discount_state')->default(0);
            $table->double('charge')->default(0);
            $table->integer('discount_day')->default(0);
            $table->double('budget')->default(0);
            $table->double('extra_fee')->default(0);
            $table->integer('budget_state')->default(1);
            $table->string('bank')->nullable();
            $table->string('account_type')->nullable();
            $table->string('account_number')->nullable();
            $table->string('baloto_code')->nullable();
            $table->string('redeban_code')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo2')->nullable();
            $table->string('link')->nullable();
            $table->string('message')->nullable();
            $table->integer('first_id')->nullable();
            $table->integer('second_id')->nullable();
            $table->integer('third_id')->nullable();
            $table->integer('fourth_id')->nullable();
            $table->integer('fifth_id')->nullable();
            $table->integer('sixth_id')->nullable();
            $table->integer('seventh_id')->nullable();
            $table->integer('eighth_id')->nullable();
            $table->integer('nineth_id')->nullable();
            $table->integer('tenth_id')->nullable();
            $table->double('wallet')->default(0);
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
        Schema::dropIfExists('organizations');
    }
}
