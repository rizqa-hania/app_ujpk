<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanLemburMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dataLembur;

    public function __construct($data)
    {
        $this->dataLembur = $data;
    }

    public function build()
    {
        return $this->subject('Pengajuan Lembur Baru - ' . $this->dataLembur['nip'])
                    ->view('emails.pengajuan_lembur');
    }
}