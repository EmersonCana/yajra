<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Attendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->timestamp('time_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->decimal('pay',11,2)->nullable();
            $table->decimal('long',11,8);
            $table->decimal('lat',10,8);
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
        Schema::dropIfExists('attendances');
    }
}
