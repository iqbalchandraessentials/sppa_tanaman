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
        Schema::create('ainfos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acceptance_id');
            $table->string('valueid1')->nullable();
            $table->string('valuedesc1')->nullable();
            $table->string('valueid2')->nullable();
            $table->string('valuedesc2')->nullable();
            $table->string('valueid3')->nullable();
            $table->string('valuedesc3')->nullable();
            $table->string('valueid4')->nullable();
            $table->string('valuedesc4')->nullable();
            $table->string('valueid5')->nullable();
            $table->string('valuedesc5')->nullable();
            $table->string('valueid6')->nullable();
            $table->string('valuedesc6')->nullable();
            $table->string('valueid7')->nullable();
            $table->string('valuedesc7')->nullable();
            $table->string('valueid8')->nullable();
            $table->string('valuedesc8')->nullable();
            $table->string('valueid9')->nullable();
            $table->string('valuedesc9')->nullable();
            $table->string('valueid10')->nullable();
            $table->string('valuedesc10')->nullable();
            $table->string('valueid11')->nullable();
            $table->string('valuedesc11')->nullable();
            $table->string('valueid12')->nullable();
            $table->string('valuedesc12')->nullable();
            $table->string('valueid13')->nullable();
            $table->string('valuedesc13')->nullable();
            $table->string('valueid14')->nullable();
            $table->string('valuedesc14')->nullable();
            $table->string('valueid15')->nullable();
            $table->string('valuedesc15')->nullable();
            $table->timestamps();
            $table->foreign('acceptance_id')->references('id')->on('acceptances')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ainfos');
    }
};
