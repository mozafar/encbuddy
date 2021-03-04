<?php

namespace Mozafar\EncBuddy;

class EncBuddyRouteMethods
{
    /**
     * Register the encrypt and decrypt routes.
     *
     * @param  array  $options
     * @return callable
     */
    public function encryption()
    {
        return function ($options = []) {
            $namespace = '\Mozafar\EncBuddy';

            $this->group(['namespace' => $namespace], function() use ($options) {
                if ($options['encrypt'] ?? true) {
                    $this->post('encrypt', 'EncBuddyController@encrypt')->name('encrypt');
                }

                if ($options['decrypt'] ?? true) {
                    $this->post('decrypt', 'EncBuddyController@decrypt')->name('decrypt');
                }
            });
        };
    }
}
