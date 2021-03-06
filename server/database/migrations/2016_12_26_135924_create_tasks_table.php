<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('pushed')->default(false);
            $table->string('name');
            $table->integer('project_id');
            $table->integer('pipeline_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->tinyInteger('exp_manager');
            $table->tinyInteger('info_manager');
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
        Schema::dropIfExists('tasks');
    }
}
