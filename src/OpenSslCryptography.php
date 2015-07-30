<?php

/*
 * This file is part of the FiveLab Cryptography package.
 *
 * (c) FiveLab <mail@fivelab.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FiveLab\Component\Cryptography;

/**
 * Encrypt and decrypt data with use OpenSSL
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class OpenSslCryptography implements CryptographyInterface
{
    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $method;

    /**
     * @var integer
     */
    private $hashIterations;

    /**
     * Construct
     *
     * @param string  $password
     * @param string  $method
     * @param integer $hashIterations
     */
    public function __construct($password, $method, $hashIterations = 100)
    {
        $this->password = $password;
        $this->method = $method;
        $this->hashIterations = $hashIterations;
    }

    /**
     * {@inheritDoc}
     */
    public function encrypt($data, $salt)
    {
        $password = $this->generatePassword($salt);

        $vectorSize = openssl_cipher_iv_length($this->method);
        $initializationVector = openssl_random_pseudo_bytes($vectorSize);

        $encrypted = openssl_encrypt($data, $this->method, $password, OPENSSL_RAW_DATA, $initializationVector);
        $encrypted = base64_encode($initializationVector . $encrypted);

        return $encrypted;
    }

    /**
     * {@inheritDoc}
     */
    public function decrypt($data, $salt)
    {
        $password = $this->generatePassword($salt);

        $vectorSize = openssl_cipher_iv_length($this->method);
        $decrypted = base64_decode($data);

        $initializationVector = substr($decrypted, 0, $vectorSize);
        $decrypted = substr($decrypted, $vectorSize);
        $decrypted = openssl_decrypt($decrypted, $this->method, $password, OPENSSL_RAW_DATA, $initializationVector);

        return $decrypted;
    }

    /**
     * Generate password for encrypt or decrypt
     *
     * @param string $salt
     *
     * @return string
     */
    public function generatePassword($salt)
    {
        $hash = '';

        for ($i = 0; $i < $this->hashIterations; $i++) {
            $hash = md5($hash . $this->password . $salt);
        }

        return $hash;
    }
}
