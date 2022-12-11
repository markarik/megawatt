<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersExpiries extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$notification_enum = array_values(config('notification.intervals'));

		Schema::create('trackers_expiries', function (Blueprint $table) use ($notification_enum) {
			$table->id();
			$table->integer('user_id')->nullable();
			$table->integer('tracker_id');
			$table->bigInteger('activation_time');
			$table->bigInteger('expiry_time');
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
		Schema::dropIfExists('trackers_expiries');
	}
}
