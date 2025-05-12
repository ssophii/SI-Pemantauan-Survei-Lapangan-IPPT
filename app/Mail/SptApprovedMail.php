<?php

namespace App\Mail;

use App\Models\Spt;
use App\Models\Pegawai;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SptApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $spt;
    public $pegawai; // ✅ tambahkan ini

    /**
     * Create a new message instance.
     */
    public function __construct(Spt $spt, Pegawai $pegawai)
    {
        $this->spt = $spt;
        $this->pegawai = $pegawai;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('SPT Telah Ditetapkan')
                    ->view('emails.spt_approved') // Pastikan file ini ada
                    ->attach(public_path($this->spt->file_spt));
    }
}
