<?php

namespace LaraWP\Contracts\Encryption;

interface StringEncrypter
{
    /**
     * Encrypt a string without serialization.
     *
     * @param string $value
     * @return string
     *
     * @throws \LaraWP\Contracts\Encryption\EncryptException
     */
    public function encryptString($value);

    /**
     * Decrypt the given string without unserialization.
     *
     * @param string $payload
     * @return string
     *
     * @throws \LaraWP\Contracts\Encryption\DecryptException
     */
    public function decryptString($payload);
}
