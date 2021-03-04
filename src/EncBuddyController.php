<?php

namespace Mozafar\EncBuddy;

use Illuminate\Http\Request;
use Mozafar\EncBuddy\Encrypter;

class EncBuddyController
{
    public function encrypt(Request $request)
    {
        $data = $request->getContent();
        $encrypter = new Encrypter();
        $encrypted = $encrypter->encryptString($data);
        return $encrypted;
    }

    public function decrypt(Request $request)
    {
        $data = $request->getContent();
        $encrypter = new Encrypter();
        $decrypted = $encrypter->decryptString($data);
        $json = json_decode($decrypted, true);
        
        if (!is_null($json)) {
            return $json;
        }
        return $decrypted;
    }
}