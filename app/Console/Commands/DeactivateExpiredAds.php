<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Ad\Http\Entities\Ad;
use Carbon\Carbon;

class DeactivateExpiredAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:deactivate-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically deactivate ads that have passed their deactive date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredAds = Ad::where('is_active', true)
            ->where('deactive_date', '<=', Carbon::now())
            ->update(['is_active' => false]);

        $this->info("Successfully deactivated {$expiredAds} expired ads.");
        
        return Command::SUCCESS;
    }
}
