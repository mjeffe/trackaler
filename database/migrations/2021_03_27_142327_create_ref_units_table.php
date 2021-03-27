<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefUnitsTable extends Migration {
    public function up() {
        Schema::create('ref_units', function (Blueprint $table) {
            $table->id();
            $table->string('category', 80); // English Weights, Temperature, etc
            $table->string('unit', 40);  // Pounds, Millimeters, etc
            $table->string('abrev', 20); // lbs, mm, degs C, etc
            $table->text('description')->nullable(); // optional description
            //$table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('ref_units');
    }
}
