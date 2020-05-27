<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserRewardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reward_table', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('surname');
            $table->integer('agent_id');
            $table->string('tel');
            $table->string('email')->default(NULL)->nullable(true);
            $table->string('line_id');
            $table->text('address')->default(NULL)->nullable(true);
            $table->float('reward_point', 8 , 1);
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
        //
    }
}
