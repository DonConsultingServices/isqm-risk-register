<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplianceExportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $summary,
        public string $csvContent,
        public string $filename
    ) {
    }

    public function build(): self
    {
        return $this->subject('ISQM Compliance Checklist')
            ->view('emails.compliance-export')
            ->with(['summary' => $this->summary])
            ->attachData($this->csvContent, $this->filename, [
                'mime' => 'text/csv',
            ]);
    }
}
