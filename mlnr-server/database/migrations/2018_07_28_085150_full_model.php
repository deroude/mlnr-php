<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FullModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodge', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('number');
            $table->string('orient');
            $table->timestamps();
            $table->enum('status', App\Domain\Lodge::$STATUSES);
        });

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', App\Domain\User::$ROLES);
            $table->enum('rank', App\Domain\User::$RANKS);
            $table->enum('assignment', App\Domain\User::$ASSIGNMENTS);
            $table->enum('status', App\Domain\User::$STATUSES);
            $table->unsignedInteger('lodge');
            $table->timestamps();
            $table->foreign('lodge')->references('id')->on('lodge');
            $table->index('email');
        });

        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('text');
            $table->timestamp('published');
            $table->enum('access', App\Domain\User::$RANKS);
            $table->unsignedInteger('author');
            $table->timestamps();
            $table->foreign('author')->references('id')->on('user');
        });

        Schema::create('meeting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location');
            $table->text('text');
            $table->enum('type', App\Domain\Meeting::$TYPES);
            $table->timestamp('date');
            $table->timestamps();
        });

        Schema::create('rsvp', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('answer', App\Domain\RSVP::$ANSWERS);
            $table->text('text');
            $table->unsignedInteger('user');
            $table->unsignedInteger('meeting');
            $table->foreign('user')->references('id')->on('user');
            $table->foreign('meeting')->references('id')->on('meeting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rsvp');
        Schema::drop('meeting');
        Schema::drop('article');
        Schema::drop('user');
        Schema::drop('lodge');
    }
}
