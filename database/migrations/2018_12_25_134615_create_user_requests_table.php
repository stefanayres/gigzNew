<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requestingUser_id')->unsigned();
            $table->integer('requestedUser_id');
            $table->string('location')->nullable();
            $table->text('details')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->dateTime('requestDate');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::table('user_requests', function ($table){
          $table->foreign('requestingUser_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign(['requestingUser_id']);
        Schema::dropIfExists('user_requests');
    }
}
