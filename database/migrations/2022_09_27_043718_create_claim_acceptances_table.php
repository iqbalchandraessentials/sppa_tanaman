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
        Schema::create('claim_acceptances', function (Blueprint $table) {
            $table->id();
            $table->string('regno');
            $table->enum('approval', ['Y', 'N', 'W', 'P'])->default('w');
            $table->string('nama');
            $table->string('alamat');
            $table->string('file_polis');
            $table->string('berita_acara');
            $table->unsignedBigInteger('acceptance_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('claim_info_id');
            $table->timestamps();
            // $table->foreign('product_id')->references('id')->on('products')->onUpdate('RESTRICT')->onDelete('CASCADE');
            // $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('CASCADE');
            // $table->foreign('client_id')->references('id')->on('clients')->onUpdate('RESTRICT')->onDelete('CASCADE');
            // $table->foreign('claim_info_id')->references('id')->on('claim_infos')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_acceptances');
    }
};
