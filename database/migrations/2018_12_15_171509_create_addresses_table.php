<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('addressable_id')->index();
            $table->string('addressable_type')->index();
            $table->enum('type', ['mailing', 'physical', 'shipping', 'billing'])->default('mailing')->index();
            $table->string('addressee')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal')->nullable();
            $table->string('postal_additional')->nullable();
            $table->string('country', 2)->default('US')->nullable();
            $table->string('phone')->nullable();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->boolean('default')->default(0);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('addresses');
    }
}
