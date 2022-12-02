<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class UpdateTrackersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trackers', function (Blueprint $table) {
			$table->boolean('notification_sent')->after('expiry_time_old')->default(new Expression(0));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('trackers', function (Blueprint $table) {
		    $table->dropColumn('notification_sent');
		});
	}

}
