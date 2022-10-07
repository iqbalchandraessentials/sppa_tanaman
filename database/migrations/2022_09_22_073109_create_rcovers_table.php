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
        Schema::create('rcovers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acceptance_id');
            $table->string('rate_code', 20);
            $table->float('rate');
            $table->enum('unit', ['C', 'M', 'F']);
            $table->string('description', 191);
            $table->date('sdate');
            $table->date('edate');
            $table->integer('scaling')->default(0);
            $table->double('premium')->default(0);
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
        Schema::dropIfExists('rcovers');
    }
};
