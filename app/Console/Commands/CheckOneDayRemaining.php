<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Tracker;
use App\MyHelpers\CommonHelpers;
use App\Models\TrackerExpiry;

class CheckOneDayRemaining extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:remain-one-Day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to check  trackers that are One day to expire  and save it to the tracker expirely section';

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
        $sys_paybill = env('SYS_PAYBILL');
        $sys_phone_numbers = env('SYS_PHONE_NUMBERS');


        $sms_tpl = 'Hello #client_name,' . "\r\n";
        $sms_tpl .= 'Your vehicle #car_plate annual tracking  fee will expire tommorrow ' . "\r\n";
        $sms_tpl .= 'Paybill: ' . $sys_paybill . "\r\n";
        $sms_tpl .= 'Acc No: #car_plate' . "\r\n";
        $sms_tpl .= 'Make plans to topup your subscription to continue enjoying your tracking experience.' . "\r\n";
        $sms_tpl .= 'Call us on ' . $sys_phone_numbers;
        
        $find = ['#client_name', '#renewal_rate', '#car_plate', '#expiry_date'];

        $dt = Carbon::now()->addDay();
        $dateformated = $dt->toDateString();
              $trackers_expiries = TrackerExpiry::with('tracker.client')    
    -> where('expiry_time', '=', CommonHelpers::excelTimeToUnixTime($dateformated))    
    ->get();        
        if( $trackers_expiries ){            
            foreach($trackers_expiries as $key => $expiry){
                $client = $expiry->tracker->client;
                $plate_no = str_replace(' ', '', $expiry->mv_reg_no);

                    $replace = [
                        explode(' ', ucfirst(strtolower($client->name)))[0], 
                        $expiry->amount, 
                        $plate_no, 
                        date('j-M-y', (strtotime($expiry->expiry_time))) 
                    ];
                    $sms_body = str_replace($find, $replace, $sms_tpl);
                   CommonHelpers::sendSms($client->phone_no, $sms_body);
                    
            }
        }
    }
}
