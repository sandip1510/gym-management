<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('duration_in_days');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('membership_plans'); }
};