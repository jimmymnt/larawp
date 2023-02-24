<?php

namespace LaraPress\Session;

use LaraPress\Contracts\Encryption\DecryptException;
use LaraPress\Contracts\Encryption\Encrypter as EncrypterContract;
use SessionHandlerInterface;

class EncryptedStore extends Store
{
    /**
     * The encrypter instance.
     *
     * @var \LaraPress\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * Create a new session instance.
     *
     * @param string $name
     * @param \SessionHandlerInterface $handler
     * @param \LaraPress\Contracts\Encryption\Encrypter $encrypter
     * @param string|null $id
     * @return void
     */
    public function __construct($name, SessionHandlerInterface $handler, EncrypterContract $encrypter, $id = null)
    {
        $this->encrypter = $encrypter;

        parent::__construct($name, $handler, $id);
    }

    /**
     * Prepare the raw string data from the session for unserialization.
     *
     * @param string $data
     * @return string
     */
    protected function prepareForUnserialize($data)
    {
        try {
            return $this->encrypter->decrypt($data);
        } catch (DecryptException $e) {
            return serialize([]);
        }
    }

    /**
     * Prepare the serialized session data for storage.
     *
     * @param string $data
     * @return string
     */
    protected function prepareForStorage($data)
    {
        return $this->encrypter->encrypt($data);
    }

    /**
     * Get the encrypter instance.
     *
     * @return \LaraPress\Contracts\Encryption\Encrypter
     */
    public function getEncrypter()
    {
        return $this->encrypter;
    }
}
