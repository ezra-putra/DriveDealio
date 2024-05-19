<?php

namespace App\Console\Commands;

use App\Models\AuctionOrder;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\User;
use App\Notifications\MonthlyPayment;
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
        $loans = Loan::where('status', 'Approved')->get();

        if ($loans->isEmpty()) {
            $this->error('No active loans found.');
            return 1;
        }

        foreach ($loans as $loan) {
            $idloan = $loan->id;
            $iduser = $loan->users_id;
            $monthlypayment = $loan->monthlypayment;
            $loantenor = $loan->loantenor * 12;

            $auctionOrder = DB::table('auction_orders')
            ->join('loans', 'auction_orders.id', '=', 'loans.auction_orders_id')
            ->where('loans.id', $idloan)
            ->select('auction_orders.status')
            ->first();

            if ($auctionOrder && $auctionOrder->status === 'Finished') {

                $existingPayments = LoanPayment::where('loans_id', $idloan)
                    ->max('paymentcount');

                $counter = ($existingPayments !== null) ? $existingPayments + 1 : 1;

                if ($counter > $loantenor) {
                    $this->info("Loan payment for loan ID $idloan completed.");
                    $loan->update(['status' => 'Finished']);
                    continue;
                }
                $loanPayment = new LoanPayment;
                $loanPayment->invoicenum = "INV/MP/" . now()->format('Y/m/d') . "/$idloan/$counter";
                $loanPayment->loans_id = $idloan;
                $loanPayment->total_bill = $monthlypayment;
                $loanPayment->type = "Monthly Payment";
                $loanPayment->status = "Unpaid";
                $loanPayment->paymentcount = $counter;
                $loanPayment->save();

                $user = User::find($iduser);
                $title = 'Bill Payment';
                $message = 'Installment Bill is Payable now, Pay Now!';
                $user->notify(new MonthlyPayment($title, $message));

                $this->info("Loan payment recorded successfully for loan ID $idloan.");
            } else {
                $this->info("Loan payment for loan ID $idloan not recorded as the vehicle has not been delivered to the buyer yet.");
            }
        }
        return 0;
    }
}
