<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('createdby_user_id');
            $table->foreign('createdby_user_id')
                ->on('users')->references('id')
                ->onDelete('cascade');
            $table->unsignedBigInteger('updatedby_user_id');
            $table->foreign('updatedby_user_id')
                ->on('users')->references('id')
                ->onDelete('cascade');
            $table->unsignedBigInteger('deletedby_user_id');
            $table->foreign('deletedby_user_id')
                ->on('users')->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
