<?php

namespace App\Console\Commands;

use App\Services\JsonWebToken;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class TestCommand extends Command
{
    protected $signature = 'test';


    public function handle()
    {
        dd($builder = (new CaptchaBuilder())->build()->getPhrase());
        $token = JsonWebToken::encode(['jti' => 10]);
        sleep(1);
        $payload = JsonWebToken::decode($token, true);
        dd($token, $payload);
    }
}
