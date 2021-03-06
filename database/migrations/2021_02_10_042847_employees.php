<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

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
        /DB::statement("CREATE SEQUENCE employees_id_seq");
        /DB::statement("ALTER TABLE employees");
        /DB::statement("ALTER id");
        /DB::statement("SET DEFAULT NEXTVAL('project_id_seq');")
        /DB::statement("ALTER SEQUENCE employees_id_seq RESTART 102020");
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
