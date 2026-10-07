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
        Schema::create('api_hits', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint');
            $table->integer('hit_count')->default(0);
            $table->double('response_duration', 8, 2)->nullable();
            $table->string('ip_address')->nullable();
            $table->string('http_method')->nullable();
            $table->string('user_agent')->nullable();
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
        Schema::dropIfExists('api_hits');
    }
};
