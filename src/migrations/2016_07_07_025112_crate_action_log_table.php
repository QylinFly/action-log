<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateActionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->nullable();
            $table->string('action_logable_type')->nullable();
            $table->unsignedInteger('action_logable_id')->nullable();

            $table->string("type","50")->comment("Custom type of operation");
            $table->string("method","10");
            $table->string("ip","50")->nullable();
            $table->string("browser",150)->nullable();
            $table->string("system",50)->nullable();
            $table->text("user_agent")->nullable();
            $table->string("url",150);
            $table->text("content");

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
        Schema::drop('action_log');
    }
}
