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
        Schema::create('claim_infos', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_pertanggungan');
            $table->string('penyebab_kerugian');
            $table->date('tanggal_kerugian');
            $table->string('waktu_kerugian');
            $table->string('kronologi');
            $table->string('okupasi_harta_peristiwa');
            $table->string('harta_tercantum_polis');
            $table->string('perubahan_okupasi_harta')->nullable();
            $table->integer('nilai_sebelum_peristiwa');
            $table->integer('nilai_setelah_peristiwa');
            $table->string('pernah_terjadi_kerugian', ['Y', 'N']);
            $table->string('memiliki_asuransi_lain', ['Y', 'N']);
            $table->enum('syarat_terpenuhi', ['Y', 'N']);
            $table->string('pihaklain_terhadap_harta')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('claim_infos');
    }
};
