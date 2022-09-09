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

            $table->date('fechaInicio'); 
            $table->date('fechaFin');
            $table->string('descripcion',255)->nullable();

            /*$table->unsignedBigInteger('tipo_contrato_id');
            $table->foreign('tipo_contrato_id')->references('id')->on('tipo_contratos');*/

            $table->string('nota',255)->nullable();

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
