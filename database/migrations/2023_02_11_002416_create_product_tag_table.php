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
        Schema::create('product_tag', function (Blueprint $table) {
            $table->foreignId('idProduct');
            $table->foreignId('idTag');
            
            $table->foreign('idProduct')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('idTag')->references('id')->on('tag')->onDelete('cascade');
            
            $table->primary(['idProduct', 'idTag']);
            
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
        Schema::dropIfExists('product_tag');
    }
};
