<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Employees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_initial');
            $table->integer('position');
            $table->decimal('rate',11,2);
            $table->timestamps();
        });
        
        DB::table('employees')->insert(['id' => 102021, 'first_name' => 'whatever', 'last_name' => 'w', 'middle_initial' => 's', 'position' => '1', 'rate' => '1']);
        DB::table('employees')->where('id', 102021)->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
