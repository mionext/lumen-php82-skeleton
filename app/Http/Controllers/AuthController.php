<?php

namespace App\Http\Controllers;

use App\Services\CaptchaService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function signIn(Request $request)
    {
        $validated = $this->validate($request, [
            'mobile' => 'required|max:11|min:11',
            'password' => 'required',
            'phrase' => 'required',
            'captcha' => 'required|min:4',
        ]);

        if (!CaptchaService::verify(
            $request->get('phrase'), $request->get('captcha'))) {
            return failWithCode(422, 'Invalid captcha.');
        }

        return success($validated);
    }
}
