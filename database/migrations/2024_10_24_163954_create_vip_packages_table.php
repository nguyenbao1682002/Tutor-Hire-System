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
        Schema::create('vip_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phu_huynh_id')->constrained('phu_huynhs')->onDelete('cascade');
            $table->string('package_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('vip_package_id')->constrained('vip_package_details');
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
        Schema::dropIfExists('vip_packages');
    }
};
