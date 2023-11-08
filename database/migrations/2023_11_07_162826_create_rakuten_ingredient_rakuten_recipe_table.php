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
        Schema::create('rakuten_ingredient_rakuten_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rakuten_recipe_id')->constrained()->onDelete('cascade');
            $table->foreignId('rakuten_ingredient_id')->constrained()->onDelete('cascade');
            $table->string('serving', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rakuteningredient_recipe');
    }
};
