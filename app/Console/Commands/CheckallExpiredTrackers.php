<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Tracker;
use App\MyHelpers\CommonHelpers;
use App\Models\TrackerExpiry;





class CheckallExpiredTrackers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:checkExpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to check  trackers that are one month to expire  and save it to the tracker expirely section';

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
    public function handle(){
        $dt = Carbon::now()->addMonth();
        $dateformated = $dt->toDateString();

        $sys_paybill = env('SYS_PAYBILL');
        $sys_phone_numbers = env('SYS_PHONE_NUMBERS');


        $sms_tpl = 'Dear #client_name,' . "\r\n";
        $sms_tpl .= 'Your vehicle #car_plate, tracking will expire on  '.$dateformated . ' Renew your yearly subscription to:- '. "\r\n";
        $sms_tpl .= 'Paybill: ' . $sys_paybill . "\r\n";
        $sms_tpl .= 'Acc No: #car_plate' . "\r\n";
        $sms_tpl .= 'Amount: #renewal_rate' . "\r\n";
        $sms_tpl .= 'To continue enjoying your tracking experience '. "\r\n";


        $sms_tpl .= 'MTL call center ' . $sys_phone_numbers;


        
        $find = ['#client_name', '#renewal_rate', '#car_plate'];




    $trackers_expiries = Tracker::with('client')
    ->where('notification_sent','=',0)    
    -> where('expiry_time','=', CommonHelpers::excelTimeToUnixTime($dateformated))
    ->get();    
    
        if( $trackers_expiries ){
            
            foreach($trackers_expiries as $key => $expiry){
                $client = $expiry->client;
                $plate_no = str_replace(' ', '', $expiry->mv_reg_no);

                    $replace = [
                        explode(' ', ucfirst(strtolower($client->name)))[0], 
                        $expiry->amount, 
                        $plate_no, 
                        date('j-M-y', (strtotime($expiry->expiry_time))) 
                    ];
                    $sms_body = str_replace($find, $replace, $sms_tpl);
                    $sent = CommonHelpers::sendSms($client->phone_no, $sms_body);
                    if( $sent ){
                    $expiry->notification_sent = 1;
                    $expiry->save();
                        $tracker_expiry_data = [
                            'tracker_id' => $expiry->id, 
                            'client_id' => $expiry->client_id, 

                            'activation_time' => CommonHelpers::excelTimeToUnixTime($expiry->init_activation_time), 
                            'expiry_time' => CommonHelpers::excelTimeToUnixTime($expiry->expiry_time), 
                        ];
                        $trackExpire = TrackerExpiry::where('tracker_id', $expiry->id)->first();
                        if ($trackExpire !== null) {
                        } else {
                            TrackerExpiry::create($tracker_expiry_data);
                        }
                    }
                    
            }
        }
		}
		
}
