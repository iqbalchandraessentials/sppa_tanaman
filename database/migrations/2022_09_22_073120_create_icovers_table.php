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
        Schema::create('icovers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acceptance_id');
            $table->double('tsi');
            $table->string('description');
            $table->foreign('acceptance_id')->references('id')->on('acceptances')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::dropIfExists('icovers');
    }
};
