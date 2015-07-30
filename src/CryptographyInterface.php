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
 * All encrypt systems should implement this interface
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface CryptographyInterface
{
    /**
     * Encrypt data
     *
     * @param string $data
     * @param string $salt
     *
     * @return string
     */
    public function encrypt($data, $salt);

    /**
     * Decrypt data
     *
     * @param string $data
     * @param string $salt
     *
     * @return string
     */
    public function decrypt($data, $salt);
}
