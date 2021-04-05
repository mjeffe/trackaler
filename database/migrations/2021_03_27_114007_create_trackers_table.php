<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersTable extends Migration {
    public function up() {
        Schema::create('trackers', function (Blueprint $table) {
            $table->id()->from(1000);
            $table->bigInteger('user_id');
            $table->string('metric', 80);
            $table->string('units', 20);  // for display only
            $table->string('description', 400)->nullable();
            $table->string('goal_value', 20)->nullable();
            $table->timestamp('goal_date')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('trackers');
    }
}
