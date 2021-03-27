<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricsTable extends Migration
{
    public function up() {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id(); //->from(100000);
            $table->bigInteger('user_id');
            $table->bigInteger('tracker_id');
            $table->text('value_integer_part');
            $table->text('value_decimal_part')->nullable();
            $table->timestamp('measured_on')->useCurrent();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('metrics');
    }
}
