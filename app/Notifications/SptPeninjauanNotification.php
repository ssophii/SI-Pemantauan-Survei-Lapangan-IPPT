<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SptPeninjauanNotification extends Notification
{
    use Queueable;

    public $spt; // tambahkan property spt

    public function __construct($spt)
    {
        $this->spt = $spt; // simpan spt ke property
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('SPT Baru Untuk Ditinjau')
            ->line('Terdapat SPT baru dengan nomor: ' . $this->spt->id_pendaftaran)
            ->action('Lihat SPT', route('spt.index')) // sesuaikan dengan route kamu
            ->line('Silakan tinjau dan tetapkan SPT tersebut.');
    }
}
