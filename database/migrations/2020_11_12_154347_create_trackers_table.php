<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateTrackersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trackers', function (Blueprint $table) {
			$table->id();
			$table->integer('client_id');
			$table->string('agent_id');
			$table->string('id_no')->unique();
			$table->string('iccid')->unique();
			$table->string('type');
			$table->string('sim_card_no');
			$table->string('mv_reg_no');
			$table->integer('amount');
			$table->bigInteger('creation_time');
			$table->bigInteger('init_activation_time');
			$table->bigInteger('expiry_time');
			$table->boolean('notification_sent')->default(new Expression(0));

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
		Schema::dropIfExists('trackers');
	}
}
