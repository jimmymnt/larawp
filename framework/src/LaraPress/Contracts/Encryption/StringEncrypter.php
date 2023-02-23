<?php

namespace LaraPress\Contracts\Encryption;

interface StringEncrypter
{
    /**
     * Encrypt a string without serialization.
     *
     * @param string $value
     * @return string
     *
     * @throws \LaraPress\Contracts\Encryption\EncryptException
     */
    public function encryptString($value);

    /**
     * Decrypt the given string without unserialization.
     *
     * @param string $payload
     * @return string
     *
     * @throws \LaraPress\Contracts\Encryption\DecryptException
     */
    public function decryptString($payload);
}
