<?php

namespace App\Console\Commands;

use App\Mail\ComplianceExportMail;
use App\Services\ComplianceExportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendComplianceDigest extends Command
{
    protected $signature = 'isqm:compliance-digest {--module=} {--severe=} {--pervasive=}';
    protected $description = 'Distribute compliance obligations via email and Teams.';

    public function handle(ComplianceExportService $service): int
    {
        $filters = [
            'module' => $this->option('module'),
            'severe' => $this->option('severe') !== null ? filter_var($this->option('severe'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
            'pervasive' => $this->option('pervasive') !== null ? filter_var($this->option('pervasive'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
        ];

        $entries = $service->fetch($filters);
        if ($entries->isEmpty()) {
            $this->info('No compliance items found for the provided filters. Skipping notifications.');
            return Command::SUCCESS;
        }

        $csv = $service->toCsv($entries);
        $summary = $service->summary($entries);

        $emails = collect(explode(',', (string) config('isqm.compliance_email_recipients')))
            ->map(fn($email) => trim($email))
            ->filter();

        if ($emails->isNotEmpty()) {
            Mail::to($emails->all())->send(new ComplianceExportMail($summary, $csv['content'], $csv['filename']));
            $this->info('Compliance export emailed to: '.$emails->implode(', '));
        } else {
            $this->warn('No compliance email recipients configured.');
        }

        if ($webhook = config('isqm.compliance_teams_webhook')) {
            $message = "ISQM compliance digest generated. Total items: {$summary['total']} (Severe: {$summary['severe']}, Pervasive: {$summary['pervasive']}).";
            Http::post($webhook, [
                'text' => $message."\nView details: ".url('/isqm/compliance-now'),
            ]);
            $this->info('Compliance summary posted to Teams webhook.');
        } else {
            $this->warn('No Teams webhook configured.');
        }

        $this->info('Compliance digest completed.');
        return Command::SUCCESS;
    }
}
