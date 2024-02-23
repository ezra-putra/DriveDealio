<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanMonthlyPaymentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle monthly loan payments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch all active loans
        $loans = Loan::where('status', 'Approved')->get();

        if ($loans->isEmpty()) {
            $this->error('No active loans found.');
            return 1; // Return error code
        }

        foreach ($loans as $loan) {
            $idloan = $loan->id;
            $monthlypayment = $loan->monthlypayment;
            $loantenor = $loan->loantenor * 12;

            // Fetch existing payments for the loan
            $existingPayments = LoanPayment::where('loans_id', $idloan)
                ->max('paymentcount');

            // If there are no existing payments, set the counter to 1, otherwise increment it
            $counter = ($existingPayments !== null) ? $existingPayments + 1 : 1;

            if ($counter > $loantenor) {
                $this->info("Loan payment for loan ID $idloan completed.");
                $loan->update(['status' => 'Finished']);
                continue; // Move to next loan
            }

            // Create loan payment record
            $loanPayment = new LoanPayment;
            $loanPayment->invoicenum = "INV/MP/" . now()->format('Y/m/d') . "/$idloan/$counter";
            $loanPayment->loans_id = $idloan;
            $loanPayment->total_bill = $monthlypayment;
            $loanPayment->type = "Monthly Payment";
            $loanPayment->status = "Unpaid";
            $loanPayment->paymentcount = $counter;
            $loanPayment->save();

            $this->info("Loan payment recorded successfully for loan ID $idloan.");
        }

        return 0; // Return success code
    }


}
