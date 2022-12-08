<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\MyHelpers\CommonHelpers;
use App\Models\TrackerExpiry;


class CheckTwoWeeksRemaining extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:remain-two-weeks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to check  trackers that are 2 weeks to expire  and save it to the tracker expirely section';

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
        $dt = Carbon::now()->addWeeks(2);
        $dateformated = $dt->toDateString();

        $sys_paybill = env('SYS_PAYBILL');
        $sys_phone_numbers = env('SYS_PHONE_NUMBERS');


        $sms_tpl = 'Hello #client_name,' . "\r\n";
        $sms_tpl .= 'Your vehicle #car_plate annual tracking  fee will expire in 14 days time on '.$dateformated . "\r\n";
        $sms_tpl .= 'Paybill: ' . $sys_paybill . "\r\n";
        $sms_tpl .= 'Acc No: #car_plate' . "\r\n";
        $sms_tpl .= 'Make plans to topup your subscription to continue enjoying your tracking experience.' . "\r\n";
        $sms_tpl .= 'Call us on ' . $sys_phone_numbers;
        
        $find = ['#client_name', '#renewal_rate', '#car_plate', '#expiry_date'];


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
