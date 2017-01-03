<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->tinyInteger('sample_type')->nullable();
            $table->string('sender')->nullable();
            $table->string('sender_contact')->nullable();
            $table->date('send_time')->nullable();
            $table->tinyInteger('arrive_status')->nullable();
            $table->string('store_location')->nullable();
            $table->date('arrive_time')->nullable();
            $table->tinyInteger('recipient')->nullable();
            $table->string('express_num')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('batches');
    }
}
