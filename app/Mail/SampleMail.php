<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SampleMail extends Mailable
{
    use Queueable, SerializesModels;

    // public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public $data;

    public function __construct() {
        // $this->data = $data;
    }

    public function build()
    {
        // return $this->view('emails.sample');
    }

    public function postulant($data)
    {
        return $this->view('emails.postulant',['data' => $data])->subject($data['subject']);
    }

    public function verif($data)
    {
        return $this->view('emails.postulant',['data' => $data]);
    }

    public function pdf($data)
    {
        return $this->view('emails.pdf')->attachData($data['pdf'], 'Autorisation.pdf',[
            'mime' => 'application/pdf',
        ]);
    }
}
