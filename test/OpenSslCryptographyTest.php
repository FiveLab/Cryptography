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
 * OpenSSL Cryptography tests
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class OpenSslCryptographyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Base testing
     *
     * @param string $method
     *
     * @dataProvider provideMethods
     */
    public function testBase($method)
    {
        $cryptography = new OpenSslCryptography('foo-bar', $method, rand(1, 100));

        $data = 'This is string for test encrypt and decrypt';
        $salt = uniqid();

        $encrypted = $cryptography->encrypt($data, $salt);

        $this->assertNotEquals($data, $encrypted, 'Not encrypt data.');

        // Test #1: Try decrypt without salt
        $decrypted = $cryptography->decrypt($encrypted, null);
        $this->assertNotEquals($data, $decrypted, 'The data encrypt without salt.');

        // Test #2: Try decrypt with any salt
        $decrypted = $cryptography->decrypt($encrypted, uniqid());
        $this->assertNotEquals($data, $decrypted, 'The data not correct encrypted with salt.');

        // Test #3: Correct decrypt data
        $decrypted = $cryptography->decrypt($encrypted, $salt);
        $this->assertEquals($data, $decrypted);
    }

    /**
     * Provide methods
     *
     * @return array
     */
    public function provideMethods()
    {
        return [
            ['aes128']
        ];
    }
}
