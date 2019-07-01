<?php declare(strict_types=1);

/**
 * Otp.php
 * 
 * PHP version 7
 * 
 * @category Dcrypt
 * @package  Dcrypt
 * @author   Michael Meyer (mmeyer2k) <m.meyer2k@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/mmeyer2k/dcrypt
 */

namespace Dcrypt;

/**
 * A one time pad stream encryption class.
 * 
 * @category Dcrypt
 * @package  Dcrypt
 * @author   Michael Meyer (mmeyer2k) <m.meyer2k@gmail.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     https://github.com/mmeyer2k/dcrypt
 * @link     http://en.wikipedia.org/wiki/Stream_cipher
 */
class Otp
{
    /**
     * Encrypt or decrypt a binary input string.
     * 
     * @param string $input Input data to encrypt
     * @param string $key   Encryption/decryption key to use on input
     * @param string $algo  Hashing algo to generate keystream
     * @return string
     */
    public static function crypt(string $input, string $key, string $algo = 'sha3-512'): string
    {
        $chunks = \str_split($input, Str::hashSize($algo));

        $length = Str::strlen($input);

        $key = new OpensslKeyGenerator($algo, $key, '', (string)$length);

        foreach ($chunks as $i => &$chunk) {
            $info = $length . $i;
            $chunk = $chunk ^ $key->deriveKey($info);
        }

        return \implode($chunks);
    }
}
