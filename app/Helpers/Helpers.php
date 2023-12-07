<?php
namespace App\Helpers;
use App\Models\Logs;
use Auth;
use DB;
use Config;
use Illuminate\Support\Facades\Mail;

class Helpers
{
    /*
	 * Below method to log API request data 
	 */
	public static function apiLogs($requestData,$requestLabel,$method){
	    $fileName = date('d-m-Y');
        $content = $requestLabel.' : '.$method.PHP_EOL.date('d-m-Y H:i:s').PHP_EOL.$requestData;
        $path = public_path() . "/apilogs";
        if (!is_dir($path))
        {
            mkdir($path, 0777);

        }
        $fp = fopen($path . "/".$fileName.".log","a+");
        fwrite($fp,$content. PHP_EOL.PHP_EOL);
        fclose($fp);
	}

    /*
	 * Below method for used to the send email usin smtp 
	 */
	public static function sendEmail($to_email,$email_title,$email_body,$email_subject){

		$msg = array();

		// Get smtp confiure value from settings table    
		$email_config = DB::table('settings')->select('value', 'name')->whereIn('name', array('port', 'username', 'password', 'from_email','host'))->get()->toArray();

		// Convert MD array to single array
		$email_config_array = array_column($email_config, 'value', 'name');
        
		// Setuo config array values
		$config = [
			//'driver' => 'smtp',
			'driver' => 'sendmail',
			'host' => $email_config_array['host'],
			'port' => $email_config_array['port'],
			'encryption' => 'tls',
			'username' => $email_config_array['username'],
			'from' => array('address' => $email_config_array['from_email'], 'name' => $email_config_array['from_email']),
			'password' => $email_config_array['password'],
			'sendmail' => '/usr/sbin/sendmail -bs',
			'pretend' => false,
			'stream' => [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ],
		];

		// Set Config value in smtp
		Config::set('mail', $config);

		// Set email title
		$data['title'] = $email_title;

		$input_data = array('to_email' => $to_email, 'email_subject' => $email_subject,'email_body'=> $email_body);    

		Mail::send([], [], function ($message) use ($input_data) {
			$message->to($input_data['to_email'], 'Test')
			->subject($input_data['email_subject'])
			->setBody($input_data['email_body'], 'text/html'); // for HTML rich messages
		});

		// Send for mail send or not
		if (Mail::failures()) {
			// If mail not send than show error 
			$msg['status'] = 400;
			$msg['message'] = trans('messages.mail_sent_fail');
			$http_code = '400';
		} else {
			$msg['status'] = 200;
			$msg['message'] = trans('messages.mail_sent_success');
			$http_code = '200';
		}
		
		// Send email responase
		return $msg;

    }

    /**
     * Below method to store logs in table
    */
    public static function storeLogs($url=Null,$requestData=Null,$responseData=Null,$type=Null,$startCron=Null,$endCron=Null){
        // Delete 15 days ago records
        $currentDate = date('d-m-Y H:i:s');
        $oldRecordDate =  date('Y-m-d',strtotime('-15 days', strtotime($currentDate)));
        Logs::whereDate('created_at', '<=', $oldRecordDate)->delete();
        
        $userId = Null;
        if($type == 0){
            // Get login user id
            if(isset(Auth::user()->id) && !empty(Auth::user()->id)){
                $userId = Auth::user()->id;
            }
            
        }

        $logs = new Logs();
        $logs->userId = $userId;
        $logs->url = $url;
        $logs->requestData = $requestData;
        $logs->responseData = $responseData;
        $logs->type = $type;
        $logs->startCron = $startCron;
        $logs->endCron = $endCron;
        $logs->created_at = $currentDate;
        $logs->save();
    }
}   
