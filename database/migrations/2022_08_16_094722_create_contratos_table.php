<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->timestamp('fechaInicio')->nullable();
            $table->timestamp('fechaFin')->nullable();
            $table->string('descripcion',255)->nullable();
            //$table->string('nota',255)->nullable();
            $table->string('salario',255);
            
            /*$table->unsignedBigInteger('funcion_id');
            $table->foreign('funcion_id')->references('id')->on('function_areas');*/

            $table->enum('estado',['Activo','Finalizado'])->default('Activo');

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
        Schema::dropIfExists('contratos');
    }
}
