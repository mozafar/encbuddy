<?php

    return [

        'enabled' => env('ENCBUDDY_ENABLED', false),
        'key' => env('ENCBUDDY_KEY', ''),
        /*
        |--------------------------------------------------------------
        | Custom class to get key and cipher
        |--------------------------------------------------------------
        | If set this config to null then constant key will
        | be used
        */
        'custom_key_resolver' => \Mozafar\EncBuddy\DefaultKeyResolver::class,

        /*
        |--------------------------------------------------------------
        | Encryption cipher
        |--------------------------------------------------------------
        | supported ciphers: AES-256-CBC, AES-128-CBC
        */
        'cipher' => env('ENCBUDDY_CIPHER', 'AES-256-CBC'),

        /*
        |--------------------------------------------------------------
        | Query string parameters
        |--------------------------------------------------------------
        | Use these parameters name to enable or disable encryption and
        | decryption for development
        */
        'query_params' => [
            'request' => 'encreq',
            'response' => 'encres',
        ],

        /*
        |--------------------------------------------------------------
        | Encryption exceptions
        |--------------------------------------------------------------
        | Add routes to prevent encryption on them
        | this array will be used is Str::is() function
        */
        'except' => [
            'api/encrypt',
            'api/decrypt',
            // 'single/route',
            // 'all/*',
        ],
    ];
