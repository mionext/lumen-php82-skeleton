<?php

namespace App\Console\Commands;

use App\Services\JsonWebToken;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test';


    public function handle()
    {
        $token = JsonWebToken::encode(['jti' => 10]);
        sleep(1);
        $payload = JsonWebToken::decode($token, true);
        dd($token, $payload);
    }
}
