<?php

namespace App\Console\Commands;

use App\Models\IsqmEntry;
use App\Models\User;
use App\Notifications\IsqmEntryDueNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendIsqmReminders extends Command
{
    protected $signature = 'isqm:reminders';
    protected $description = 'Send reminders for ISQM entries near or past due date';

    public function handle(): int
    {
        $today = Carbon::today();
        $soon = Carbon::today()->addDays(3);

        $entries = IsqmEntry::query()
            ->whereNotNull('due_date')
            ->whereIn('status', ['open', 'monitoring'])
            ->whereBetween('due_date', [$today->copy()->subDays(30), $soon])
            ->get();

        // For demo, notify all users; in production, notify owner or role
        $users = User::all();

        foreach ($entries as $entry) {
            foreach ($users as $user) {
                $user->notify(new IsqmEntryDueNotification($entry));
            }
        }

        $this->info('Sent reminders for '.$entries->count().' entries.');
        return Command::SUCCESS;
    }
}


