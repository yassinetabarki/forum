<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThreadSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_subscriptions', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('user_id');

            $table->unsignedInteger('thread_id');

            $table->timestamps();


            $table->foreign('thread_id')

            ->references('id')

            ->on('threads')

            ->delete('cascade');

            $table->unique(['user_id','thread_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread_subscriptions');
    }
}
