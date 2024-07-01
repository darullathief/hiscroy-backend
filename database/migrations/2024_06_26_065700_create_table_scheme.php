<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('story', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->date('date_start');
            $table->date('date_finish')->nullable();
            $table->timestamps();
        });
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->timestamps();
        });
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('point');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
        Schema::create('user_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['story', 'series']);
            $table->unsignedBigInteger('relation_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
        Schema::create('series_story', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id');
            $table->unsignedBigInteger('series_id');
            $table->foreign('story_id')->references('id')->on('story');
            $table->foreign('series_id')->references('id')->on('series');
        });
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id');
            $table->string('title');
            $table->text('content');
            $table->integer('sequence');
            $table->foreign('story_id')->references('id')->on('story');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story');
        Schema::dropIfExists('series');
        Schema::dropIfExists('points');
        Schema::dropIfExists('user_history');
        Schema::dropIfExists('series_story');
        Schema::dropIfExists('events');
    }
};
