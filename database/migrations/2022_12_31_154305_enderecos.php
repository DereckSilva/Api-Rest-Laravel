<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->unsigned();
            $table->string('logradouro');
            $table->string('numero', 5);
            $table->string('complemento',55)->nullable();
            $table->string('bairro', 55);
            $table->string('cidade', 25);
            $table->string('estado', 25);
            $table->string('cep', 8);
            $table->string('latitude',12);
            $table->string('longitude',12);
            $table->timestamps();

            $table->foreign('cliente_id')
                  ->references('id')
                  ->on('clientes')
                  ->onDelete('cascade') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
};
