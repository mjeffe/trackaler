<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersTable extends Migration {
    public function up() {
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name', 80);
            $table->string('description', 400);
            $table->string('display_units', 20);  // for display only
            $table->integer('goal_integer_part')->nullable();
            $table->integer('goal_decimal_part')->nullable();
            $table->string('locale_decimal_char', 1);  // pull from the browser on create?
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('trackers');
    }
}
