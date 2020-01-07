<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrpchatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grpchat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('grpchat_id');
            $table->bigInteger('sender');
            $table->text('message');
            $table->json('seenby')->nullable();
            $table->boolean('deleted')->default('0');
            $table->foreign('grpchat_id')->references('on')->on('grpchats');
            $table->foreign('sender')->references('on')->on('users');
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
        Schema::dropIfExists('grpchat_messages');
    }
}
