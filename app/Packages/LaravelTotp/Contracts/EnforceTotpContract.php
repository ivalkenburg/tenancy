<?php

namespace App\Packages\LaravelTotp\Contracts;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Validated;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

interface EnforceTotpContract
{
    /**
     * @param Repository $config
     * @param Request $request
     */
    public function __construct(Repository $config, Request $request);

    /**
     * @param Attempting $event
     * @return void
     */
    public function saveCredentials(Attempting $event);

    /**
     * @param Validated $event
     * @return void
     */
    public function validate(Validated $event);
}
