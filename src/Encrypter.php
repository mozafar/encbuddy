<?php

namespace Mozafar\EncBuddy;

use RuntimeException;
use Illuminate\Encryption\Encrypter as IlluminateEncrypter;
use Illuminate\Support\Str;

class Encrypter extends IlluminateEncrypter
{
    public function __construct()
    {
        $key = $this->key(config('encbuddy.key'));
        $cipher = config('encbuddy.cipher');
        parent::__construct($key, $cipher);
    }
    /**
     * Extract the encryption key from the given configuration.
     *
     * @param  array|string $config
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function key($config)
    {
        if (is_array($config)) {
            $key = tap($config['key'], function ($key) {
                if (empty($key)) {
                    throw new RuntimeException('No encryption key has been specified.');
                }
            });
        } else {
            $key = $config;
        }

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        return $key;
    }
}