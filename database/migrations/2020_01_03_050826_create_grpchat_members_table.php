<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrpchatMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grpchat_members', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('grpchat_id');
            $table->bigInteger('user_id');
            $table->foreign('grpchat_id')->references('id')->on('grpchats');            
            $table->foreign('user_id')->references('id')->on('users');            
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
        Schema::dropIfExists('grpchat_members');
    }
}
