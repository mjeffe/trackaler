<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricsTable extends Migration
{
    public function up() {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id(); //->from(100000);
            $table->bigInteger('tracker_id');
            $table->string('value', 20);
            $table->timestamp('measured_on')->useCurrent();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('metrics');
    }
}
