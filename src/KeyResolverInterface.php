<?php

namespace Mozafar\EncBuddy;

interface KeyResolverInterface
{
    /**
     * Get encryption key to use in Encrypter
     */
    public function key(): string;
}
