<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SampleMail;
use Mail;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

     /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
  
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->details);
        $mail = new SampleMail();
        if($this->details['type'] == 1){
            Mail::to($this->details['email'])->send($mail->postulant($this->details));
        }elseif ($this->details['type'] == 2){
            Mail::to($this->details['email'])->send($mail->pdf($this->details));
        }elseif ($this->details['type'] == 3){
            // Mail::to($this->details['email'])->send($mail->postulant($this->details['contenu']));
        }
    }
}
