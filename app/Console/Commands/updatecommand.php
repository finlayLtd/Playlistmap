<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class updatecommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_value';

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
        // return 0;
       $subscription_ids=DB::table('plan_subscriptions')->where('plan_id',1)->get();
       foreach($subscription_ids as $sub) 
       {
           $update=DB::table('plan_subscription_usage')->where('subscription_id',$sub->id)->where('feature_id',5)->update(['used'=>0]);
       }
    }
}
