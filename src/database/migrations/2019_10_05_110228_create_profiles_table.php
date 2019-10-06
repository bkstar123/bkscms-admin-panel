<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('avatar_url')->nullable()->default(null);
            $table->string('avatar_path')->nullable()->default(null);
            $table->string('avatar_disk')->nullable()->default(null);
            $table->bigInteger('admin_id')->unique();
            $table->string('mobile')->nullable()->default(null);
            $table->string('slack_webhook_url')->nullable()->default(null);
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
        Schema::dropIfExists('profiles');
    }
}
