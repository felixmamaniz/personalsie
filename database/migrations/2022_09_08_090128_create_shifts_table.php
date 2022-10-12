<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
   // Lunes – Monday (Mondei)
//Martes – Tuesday (Tusdei)
//Miércoles – Wednesday (Güensdei)
//Jueves – Thursday (Tursdei)
//Viernes – Friday (Fraidei)
//Sábado – Saturday (Saturdei)
//Domingo – Sunday (Sondei)
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->integer('ci');
            $table->time('monday');
            $table->time('tuesday');
            $table->time('wednesday');
            $table->time('thursday');
            $table->time('friday');
            $table->time('saturday');
            $table->time('Sunday');
            $table->time('smonday');
            $table->time('stuesday');
            $table->time('swednesday');
            $table->time('sthursday');
            $table->time('sfriday');
            $table->time('ssaturday');
            $table->time('sSunday');
            $table->string('name',255);
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
        Schema::dropIfExists('shifts');
    }
}
