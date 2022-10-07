<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('multiplicado');
            $table->decimal('comision',10,2);
            $table->time('fromtime');
            $table->time('totime');
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
        Schema::dropIfExists('commissions_employees');
    }
}
