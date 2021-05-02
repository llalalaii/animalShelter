<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalRescuerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // i could create a separate migration for the other two but since they are all similar to each other ill just put them here
        Schema::create('animal_rescuer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')
                ->constrained('animals')
                ->onDelete('cascade');
            $table->foreignId('rescuer_id')
                ->constrained('rescuers')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('adopter_animal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')
                ->constrained('animals')
                ->onDelete('cascade');
            $table->foreignId('adopter_id')
                ->constrained('adopters')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('animal_sickness', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')
                ->constrained('animals')
                ->onDelete('cascade');
            $table->foreignId('sickness_id')
                ->constrained('sicknesses')
                ->onDelete('cascade');
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
        Schema::dropIfExists('animal_rescuer');
        Schema::dropIfExists('adopter_animal');
        Schema::dropIfExists('animal_sickness');
    }
}
