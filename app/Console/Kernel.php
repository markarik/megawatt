<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Crons\SendClientBroadcastMessages;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		
		Commands\PastExpiryByADay::class,
		Commands\CheckTwoWeeksRemaining::class,
		Commands\CheckOneDayRemaining::class,
		Commands\CheckallExpiredTrackers::class,
		Commands\SendMessagesToAgents::class,
		Commands\SendMessagesToClients::class,
		Commands\TopupNotification::class,



		


	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		

		$schedule->command('daily:remain-two-weeks')
		->dailyAt('11:00')->withoutOverlapping(20);
		
		$schedule->command('daily:remain-one-Day')
		->dailyAt('13:00')->withoutOverlapping(20);
		
		$schedule->command('daily:checkExpired')
		->dailyAt('00:00')->withoutOverlapping(20);

		$schedule->command('daily:past-expiry-by-a-day')
		->dailyAt('07:00')->withoutOverlapping(20);

		$schedule->command('daily:send-top-up-notification')
		->dailyAt('09:00')->withoutOverlapping(20);

		


		





		// $schedule->command('daily:send-clients-messages')
		// ->dailyAt('10:00')->withoutOverlapping(20);

		// $schedule->command('daily:send-agents-messages')
		// ->dailyAt('08:00')->withoutOverlapping(20);

		
		




	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__.'/Commands');

		require base_path('routes/console.php');
	}
}
