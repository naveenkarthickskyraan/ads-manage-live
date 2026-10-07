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
        Schema::table('ad_managers', function (Blueprint $table) {
            $table->string('audio_banner_id')->default('');
            $table->string('audio_interstitial_id')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_managers', function (Blueprint $table) {
            $table->dropColumn([
                'audio_banner_id',
                'audio_interstitial_id'
            ]);
        });
    }
};
