<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateAgentBroadcastNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_broadcast_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('broadcast_id');
            $table->integer('agent_id');
            $table->boolean('status')->default(new Expression(0));
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
        Schema::dropIfExists('agent_broadcast_notifications');
    }
}
