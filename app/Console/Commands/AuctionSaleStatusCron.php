<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\AuctionWinner;
use App\Models\Bid;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AuctionSaleStatusCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auctionsale:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auction Sale Confirmation';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $winners = AuctionWinner::all();
        $auctions = Auction::select('vehicles.id as idvehicle', 'auctions.id as idauction')->join('vehicles', 'auctions.vehicles_id', '=', 'vehicles.id')->get();

        if ($winners->isEmpty()) {
            return $this->error('No Winner in this Auction Session');
        }

        foreach ($winners as $winner) {
            $createdAt = Carbon::parse($winner->created_at);
            if (!$winner->is_checkout && $createdAt->diffInDays(Carbon::now()) > 5) {
                $idauction = $winner->auctions_id;
                $firstWinner = AuctionWinner::where('is_winner', true)->where('is_checkout', false)
                    ->where('auctions_id', $idauction)
                    ->first();
                if ($firstWinner) {
                    $firstWinner->is_winner = false;
                    $firstWinner->save();

                    $nextWinner = AuctionWinner::where('is_winner', false)->where('auctions_id', $idauction)->skip(1)->first();
                    if($nextWinner){
                        $nextWinner->is_winner = true;
                        $nextWinner->save();
                    }
                }

                $secondWinner = AuctionWinner::where('is_winner', true)->where('is_checkout', false)
                ->where('auctions_id', $idauction)
                ->first();
                if($secondWinner){
                    $secondWinner->is_winner = false;
                    $secondWinner->save();

                    $nextWinner1 = AuctionWinner::where('is_winner', false)->where('auctions_id', $idauction)->skip(2)->first();
                    if($nextWinner1){
                        $nextWinner1->is_winner = true;
                        $nextWinner1->save();
                    }
                }

                $thirdWinner = AuctionWinner::where('is_winner', true)->where('is_checkout', false)
                ->where('auctions_id', $idauction)
                ->first();
                if($thirdWinner){
                    $thirdWinner->is_winner = false;
                    $thirdWinner->save();
                }

                if(!$firstWinner && !$secondWinner && !$thirdWinner){
                    $vehicle = Vehicle::join('auctions', 'auctions.vehicles_id', '=', 'vehicles.id')
                    ->where('auctions.id', $idauction)
                    ->first();
                    $vehicle->adstatus = "Setup Auction";
                    $vehicle->save();
                }
            }
        }
        return 0;
    }
}
