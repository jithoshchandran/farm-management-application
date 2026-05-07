<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailySummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $date;
    public $totalMilk;
    public $milkDiff;
    public $totalExpenses;
    public $activeTreatmentsCount;
    public $pendingInseminationsCount;
    public $morningTotal;
    public $eveningTotal;
    public $avgMilkPerCow;
    public $topPerformer;
    public $treatmentsStarted;
    public $vaccinationsCount;
    public $withdrawalAlerts;
    public $upcomingCalvings;
    public $majorExpense;
    public $otherExpenses;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->date = $data['date'] ?? date('Y-m-d');
        $this->totalMilk = $data['totalMilk'] ?? 0;
        $this->milkDiff = $data['milkDiff'] ?? 0;
        $this->totalExpenses = $data['totalExpenses'] ?? 0;
        $this->activeTreatmentsCount = $data['activeTreatmentsCount'] ?? 0;
        $this->pendingInseminationsCount = $data['pendingInseminationsCount'] ?? 0;
        $this->morningTotal = $data['morningTotal'] ?? 0;
        $this->eveningTotal = $data['eveningTotal'] ?? 0;
        $this->avgMilkPerCow = $data['avgMilkPerCow'] ?? 0;
        $this->topPerformer = $data['topPerformer'] ?? null;
        $this->treatmentsStarted = $data['treatmentsStarted'] ?? collect();
        $this->vaccinationsCount = $data['vaccinationsCount'] ?? 0;
        $this->withdrawalAlerts = $data['withdrawalAlerts'] ?? [];
        $this->upcomingCalvings = $data['upcomingCalvings'] ?? collect();
        $this->majorExpense = $data['majorExpense'] ?? null;
        $this->otherExpenses = $data['otherExpenses'] ?? collect();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('🐄 Daily Farm Summary - ' . $this->date)
                    ->view('emails.daily-summary');
    }
}
