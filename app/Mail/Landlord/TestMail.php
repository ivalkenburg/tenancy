<?php

namespace App\Mail\Landlord;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class TestMail extends Mailable implements ShouldQueue, NotTenantAware
{
    use Queueable, SerializesModels;

    public $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return $this
     */
    public function build()
    {
        return $this->view('landlord.mail.test');
    }
}
