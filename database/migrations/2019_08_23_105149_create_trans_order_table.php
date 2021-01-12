<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_depan');
            $table->string('nama_belakang')->nullable();
            $table->string('email', 100)->unique();
            $table->string('kontak');
            $table->string('pin');
            $table->integer('order_id')->unsigned();
            $table->integer('akun_induk_id')->unsigned();
            $table->date('aktif_awal');
            $table->date('aktif_akhir');
            $table->integer('paket');
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('akun_induk_id')->references('id')->on('ref_akun_induk');
            $table->foreign('order_id')->references('id')->on('ref_order');

            $table->nullableTimestamps();

            
        });

    }


    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_order');
   
    }
}
