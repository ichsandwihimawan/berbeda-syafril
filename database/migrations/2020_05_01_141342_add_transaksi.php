<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trans_order', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->string('tipe');            
        });

        Schema::table('ref_akun_induk', function (Blueprint $table) {
            $table->string('tipe');
            $table->date('aktif_awal')->nullable();
            $table->integer('paket');
            $table->date('aktif_akhir')->nullable();
            $table->text('keterangan')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trans_order', function (Blueprint $table) {
            $table->unique('email');
            $table->dropColumn(['tipe']);

        });

        Schema::table('ref_akun_induk', function (Blueprint $table) {
            $table->dropColumn(['tipe','aktif_awal','paket','aktif_akhir','keterangan']);
        });

    }
}
