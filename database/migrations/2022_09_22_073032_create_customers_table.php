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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('place_of_birth', 50);
            $table->date('date_of_birth');
            $table->enum('identity_type', ['KTP', 'SIM', 'Passpor']);
            $table->string('identity_no');
            $table->string('home_phone', 20)->nullable();
            $table->string('office_phone', 20)->nullable();
            $table->string('handphone', 20)->nullable();
            $table->string('fax_no', 20)->nullable();
            $table->string('NPWP', 30);
            $table->enum('citizen', ['WNI', 'WNA']);
            $table->string('source_premium_payment', 20);
            $table->enum('individual', ['Y', 'N']);
            $table->string('valuedesc1');
            $table->string('valueid1')->nullable();
            $table->string('valuedesc2');
            $table->string('valueid2')->nullable();
            $table->string('valuedesc3');
            $table->string('valueid3')->nullable();
            $table->string('valuedesc4');
            $table->string('valueid4')->nullable();
            $table->string('address');
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
        Schema::dropIfExists('customers');
    }
};
