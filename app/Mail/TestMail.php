<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @return $this
     */
    public function build()
    {
        info('TestMail', ['route' => route('home'), 'url' => url('/hello/world'), 'tenant' => route('tenants.create')]);

        return $this->view('mail.test');
    }
}
