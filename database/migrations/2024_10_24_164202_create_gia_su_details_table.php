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
        Schema::create('gia_su_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gia_su_id')->constrained('gia_sus')->onDelete('cascade');
            $table->string('education_level');
            $table->integer('years_of_experience');
            $table->text('subjects_taught');
            $table->text('certifications');
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
        Schema::dropIfExists('gia_su_details');
    }
};
