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
        Schema::create('phu_huynh_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phu_huynh_id')->constrained('phu_huynhs')->onDelete('cascade');
            $table->string('phone_number');
            $table->text('address');
            $table->string('occupation');
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
        Schema::dropIfExists('phu_huynh_details');
    }
};
