<?php

namespace App\Services;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CaptchaService extends Service
{

    /**
     * @param string $mobile
     * @return array
     */
    public static function get(int $width = 150, int $height = 40)
    {
        $ttl = 300;
        $phrase = Str::uuid();
        $builder = (new CaptchaBuilder())->build($width, $height);
        Cache::put($phrase, $builder->getPhrase(), 300);

        return ['phrase' => $phrase, 'captcha' => $builder->inline(), 'ttl' => $ttl];
    }

    /**
     * @param string $subject
     * @param string $phrase
     * @param string $scene
     * @return bool
     */
    public static function verify(?string $phrase, ?string $captcha): bool
    {
        if (Cache::get($phrase) == $captcha) {
            Cache::forget($phrase);

            return true;
        }

        return false;
    }
}
