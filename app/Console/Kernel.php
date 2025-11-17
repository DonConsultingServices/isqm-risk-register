<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected function schedule(Schedule $schedule): void
	{
		$schedule->command('isqm:reminders')->dailyAt('07:00');
		$schedule->command('isqm:compliance-digest')->weeklyOn(1, '06:30');
	}

	protected function commands(): void
	{
		$this->load(__DIR__.'/Commands');
	}
}
