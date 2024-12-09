<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable(); // untuk menyimpan nama file gambar
            $table->timestamps();
            $table->string('code_1')->nullable();
            $table->string('code_2')->nullable();
            $table->string('code_3')->nullable();
            $table->string('code_4')->nullable();
            $table->string('code_5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
