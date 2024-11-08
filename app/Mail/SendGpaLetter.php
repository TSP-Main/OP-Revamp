<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendGpaLetter extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf_path;
    public $file_name;

    public function __construct($pdf_path, $file_name)
    {
        $this->pdf_path = $pdf_path;
        $this->file_name = $file_name;
    }

    public function build()
    {
        return $this->view('emails.gpa_letter')
                    ->subject('Your GPA Letter')
                    ->attach($this->pdf_path, [
                        'as' => $this->file_name,
                        'mime' => 'application/pdf',
                    ]);
    }
}
