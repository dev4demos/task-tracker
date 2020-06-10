<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $target = 'users';
        // update schema
        if (Schema::hasTable($target)) {
            Schema::table($target, function (Blueprint $table) {
                $table->string('name')->nullable()->change();
                $table->string('user_role')->nullable()->default('editor');
            });
        }
        // create schema
        else {
            Schema::create($target, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('user_role')->nullable()->default('editor');
                $table->timestamps();
            });
        }

        //
        $target = 'tasks';

        Schema::hasTable($target) ?: Schema::create($target, function (Blueprint $table) {
            $owner = 'user_id';

            $table->bigIncrements('id');
            $table->unsignedBigInteger($owner)->nullable();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();
            // indexes
            $table->unique(array($owner, 'title'));
            $table->foreign($owner)->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('users');
    }
}
