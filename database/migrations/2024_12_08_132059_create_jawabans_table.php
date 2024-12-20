<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabansTable extends Migration
{
    public function up()
    {
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('soal_id');
            $table->text('jawaban');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->foreign('soal_id')->references('id')->on('soals')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawabans');
    }
}
