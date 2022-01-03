<?php

namespace App\Console\Commands;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OrderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = Order::query()
            ->where('status','Delivered')
            ->each(function ($oldRecord) {
                $newRecord = $oldRecord->replicate();
                $newRecord->setTable('deliveries');
                $newRecord->save();

                $oldRecord->delete();
            });
        Log::info($data);
    }
}
