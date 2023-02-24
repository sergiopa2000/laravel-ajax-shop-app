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
        Schema::create('product_color', function (Blueprint $table) {
            $table->foreignId('idProduct');
            $table->foreignId('idColor');
            
            $table->foreign('idProduct')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('idColor')->references('id')->on('color')->onDelete('cascade');
            
            $table->primary(['idProduct', 'idColor']);
            
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
        Schema::dropIfExists('product_color');
    }
};
