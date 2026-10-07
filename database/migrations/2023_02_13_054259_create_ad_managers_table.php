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
        Schema::create('ad_managers', function (Blueprint $table) {
            $table->id();
            $table->string('app_type');
            $table->string('app_id');
            $table->string('ad_banner_id');
            $table->string('ad_intercial_id');
            $table->string('ad_rewards');
            $table->string('ad_intencial_video');
            $table->string('ad_rewarded_intencial');
            $table->string('ad_native_advanced');
            $table->string('ad_native_advanced_video');
            $table->string('is_active')->default(0);
            $table->string('deleted_at')->default(0);
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
        Schema::dropIfExists('ad_managers');
    }
};
