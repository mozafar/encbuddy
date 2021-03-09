<?php

namespace Mozafar\EncBuddy;

use RuntimeException;
use Illuminate\Encryption\Encrypter as IlluminateEncrypter;
use Illuminate\Support\Str;

class Encrypter extends IlluminateEncrypter
{
    public function __construct()
    {
        $key = $this->key();
        $cipher = config('encbuddy.cipher');
        parent::__construct($key, $cipher);
    }

    private function key(): string
    {
        $keyResolver = config('encbuddy.custom_key_resolver', null);
        $key = config('encbuddy.key');
        if (!is_null($keyResolver)) {
            if (!class_exists($keyResolver)) {
                throw new RuntimeException("Encryption params resolver class not exists [$keyResolver]");
            }
    
            $interfaces = class_implements($keyResolver);
            $resolverInterface = trim(KeyResolverInterface::class, '\\');
            if (($interfaces === false) || !in_array($resolverInterface, $interfaces)) {
                throw new RuntimeException("Encryption params resolver must implement [\Mozafar\EncBuddy\KeyResolverInterface]");
            }
            $keyResolver = resolve($keyResolver);
            $key = $keyResolver->key();
        } else {
            $key = config('encbuddy.key');
        }

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return $key;
    }
}
