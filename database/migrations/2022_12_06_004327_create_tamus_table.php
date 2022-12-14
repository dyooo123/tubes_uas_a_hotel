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
        Schema::create('tamus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tamu');
            $table->string('email');
            $table->string('jenis_kelamin');
            $table->string('no_telp');
            $table->string('alamat');
            $table->string('tanggal_lahir');
            $table->string('tgl_checkin');
            $table->string('tgl_checkout');
            $table->unsignedBigInteger('id_kamar');
            $table->foreign('id_kamar')->references('id')->on('kamars');
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
        Schema::dropIfExists('tamus');
    }
};
