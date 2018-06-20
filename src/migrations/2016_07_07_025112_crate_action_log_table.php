<?php

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
            $table->unsignedInteger("uid")->comment("user_id");
            $table->string("username")->comment("name");
            $table->string("type","50")->comment("Type of operation");
            $table->string("method","10")->comment("method");
            $table->string("ip","50")->comment("operation ip");
            $table->string("browser",150)->nullable()->comment("browser");
            $table->string("system",50)->nullable()->comment("system");
            $table->text("user_agent")->nullable()->comment("user_agent");
            $table->string("url",150)->comment('url');
            $table->string("content")->comment("content");

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
