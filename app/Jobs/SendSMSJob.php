<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($phoneNumber, $message)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $number = "88" . $this->phoneNumber;
        $message_url = "https://sms.rapidsms.xyz/request.php?user_id=200501&password=11111111&number=" . $number . "&message=" . urlencode($this->message);

        // Initialize CURL to send SMS
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $message_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_exec($curl);
        curl_close($curl);
    }
}
